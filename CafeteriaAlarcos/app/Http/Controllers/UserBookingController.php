<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingTables;
use App\Models\Configuration;
use App\Models\Table;
use App\Models\Turn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class UserBookingController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('role:User')->only(['index', 'store', 'cancel', 'history']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()['id'];

        return view(
            'userbookings.index',
            ['userbookings' => Booking::whereHas('user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })
                ->where('cancelled', false)
                ->whereHas('turn', function ($query) {
                    $query->whereDate('date', '>=', Carbon::now())->orderBy('date', 'DESC')->orderBy('start', 'DESC');
                })
                ->paginate(15)]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Turn $turn)
    {
        $turnId = $turn['id'];

        $tables = Table::selectRaw('tables.id, tables.quantity, tables.maxNumber, tables.minNumber, (tables.quantity - COUNT(bookings.id)) AS remaining_tables')
            ->leftJoin('booking_tables', 'tables.id', '=', 'booking_tables.table_id')
            ->leftJoin('bookings', function ($join) use ($turnId) {
                $join->on('booking_tables.booking_id', '=', 'bookings.id')
                    ->where('bookings.turn_id', '=', $turnId);
            })
            ->groupByRaw('tables.id, tables.quantity, tables.maxNumber, tables.minNumber')
            ->havingRaw('remaining_tables > 0')
            ->get();

        return view('userbookings.create', ['turn' => $turn, 'tables' => $tables]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'table_id' => ['required', Rule::exists(Table::class, 'id')],
            'turn_id' => ['required', Rule::exists(Turn::class, 'id')],
            'guests' => ['required', 'numeric', 'min:1', 'max:65535'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $tableId = $request->input('table_id');
        $turnId = $request->input('turn_id');

        $selectedTable = Table::selectRaw('tables.id, tables.quantity, tables.maxNumber, tables.minNumber, (tables.quantity - COUNT(bookings.id)) AS remaining_tables')
            ->where('tables.id', '=', $tableId)
            ->leftJoin('booking_tables', 'tables.id', '=', 'booking_tables.table_id')
            ->leftJoin('bookings', function ($join) use ($turnId) {
                $join->on('booking_tables.booking_id', '=', 'bookings.id')
                    ->where('bookings.turn_id', '=', $turnId);
            })
            ->groupByRaw('tables.id, tables.quantity, tables.maxNumber, tables.minNumber')
            ->first();

        if ($selectedTable['remaining_tables'] <= 0) {
            return back()->withInput()->withError("La mesa que has seleccionado no está disponible para este turno");
        }

        $guests = $request->input('guests');

        if (($selectedTable['maxNumber'] < $guests) || ($selectedTable['minNumber'] > $guests)) {
            return back()->withInput()->withError("Debes seleccionar una mesa habilidata para $guests comensales");
        }

        $minBookingDays = Cache::remember('minDiasReserva', now()->addHour(), function () {
            return Configuration::where('name', 'minDiasReserva')->value('value');
        });

        $selectedTurnId = $request->input('turn_id');
        $selectedTurnDate = Turn::select('date')->find($selectedTurnId)['date'];

        $now = Carbon::now();
        $date = Carbon::parse($selectedTurnDate);

        if ($now > $date) {
            return back()->withInput()->withError("Debes reservar antes de la fecha");
        }

        $days = $date->diffInDays($now);

        if ($days < $minBookingDays) {
            return back()->withInput()->withError("Debes reservar con un mínimo de $minBookingDays días de antelación");
        }

        $turnGuests = Booking::where('turn_id', $selectedTurnId)
            ->join('booking_tables', 'booking_tables.booking_id', '=', 'bookings.id')
            ->sum('guests');

        $maxGuestsTurn = Cache::remember('maxComensalesTurno', now()->addHour(), function () {
            return Configuration::where('name', 'maxComensalesTurno')->value('value');
        });

        if (($turnGuests + $guests) > $maxGuestsTurn) {
            return back()->withInput()->withError("El aforo está al máximo en este turno");
        }

        $request->merge([
            'user_id' => Auth::user()['id'],
        ]);

        $booking = Booking::create($request->all());

        $booking->bookingTables()->saveMany([
            new BookingTables(['table_id' => $request->input('table_id'), 'guests' => $request->input('guests')]),
        ]);

        $booking->refresh();

        return redirect()->route('userbookings.index');
    }

    /**
     * Display the specified resource.
     */
    // public function show(Booking $booking)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Booking $booking)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Booking $booking)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Booking $booking)
    // {
    //     //
    // }

    public function available()
    {
        $minBookingDays = Cache::remember('minBookingDays', now()->addHour(), function () {
            return Configuration::where('name', 'minBookingDays')->value('value');
        });
        $maxGuestsTurn = Cache::remember('maxComensalesTurno', now()->addHour(), function () {
            return Configuration::where('name', 'maxComensalesTurno')->value('value');
        });

        $turns = Turn::select('turns.*')
            ->whereDate('date', '>', Carbon::now()->addDays($minBookingDays))
            ->selectSub(
                function ($query) use ($maxGuestsTurn) {
                    $query->from('booking_tables')
                        ->join('bookings', 'booking_tables.booking_id', '=', 'bookings.id')
                        ->selectRaw('? - COALESCE(SUM(guests), 0)', [$maxGuestsTurn])
                        ->whereColumn('turns.id', 'bookings.turn_id');
                },
                'turn_remaining_guests'
            )
            ->selectSub(
                function ($query) {
                    $query->from('tables')
                        ->selectRaw('COUNT(*)')
                        ->whereNotIn('tables.id', function ($subquery) {
                            $subquery->from('booking_tables')
                                ->join('bookings', 'booking_tables.booking_id', '=', 'bookings.id')
                                ->select('booking_tables.table_id')
                                ->whereColumn('turns.id', 'bookings.turn_id')
                                ->groupBy('booking_tables.table_id')
                                ->havingRaw('COUNT(*) >= tables.quantity');
                        });
                },
                'tables_remaining'
            )
            ->havingRaw('turn_remaining_guests > 0 AND tables_remaining > 0')
            ->paginate(15);

        return view('userbookings.available', ['turns' => $turns]);
    }

    public function cancel(Booking $booking)
    {
        $maxCancelBookingDays = Cache::remember('maxDiasCancelacionReserva', now()->addHour(), function () {
            return Configuration::where('name', 'maxDiasCancelacionReserva')->value('value');
        });

        $now = Carbon::now();
        $date = Carbon::parse($booking['turn']['date']);

        if ($now > $date) {
            return back()->withError("Debes cancelar la reserva antes de la fecha");
        }

        $days = $date->diffInDays($now);

        if ($days < $maxCancelBookingDays) {
            return back()->withError("Debes cancelar la reserva con un mínimo $maxCancelBookingDays días de antelación");
        }

        $booking->update([
            'cancelled' => true
        ]);

        return redirect()->route('userbookings.index');
    }

    public function history()
    {
        $userId = Auth::user()['id'];

        return view(
            'userbookings.history',
            ['userbookings' => Booking::whereHas('user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })
                ->where('cancelled', true)
                ->orWhereHas('turn', function ($query) {
                    $query->whereDate('date', '<', Carbon::now())->orderBy('date', 'DESC')->orderBy('start', 'DESC');
                })
                ->paginate(15)]
        );

        return view('userbookings.history', ['userbookings' => Booking::join('turns', 'bookings.turn_id', '=', 'turns.id')->select('bookings.id as booking_id', 'bookings.description as booking_description', 'bookings.*', 'turns.*')->where('user_id', Auth::user()['id'])->where('cancelled', true)->orWhereDate('turns.date', '<', Carbon::now())->orderBy('turns.date', 'DESC')->orderBy('turns.start', 'DESC')->paginate(15)]);
    }
}
