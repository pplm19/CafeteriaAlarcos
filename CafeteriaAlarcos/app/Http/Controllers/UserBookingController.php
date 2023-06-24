<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Table;
use App\Models\Turn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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
        return view('userbookings.index', ['userbookings' => Booking::join('turns', 'bookings.turn_id', '=', 'turns.id')->select('bookings.id as booking_id', 'bookings.description as booking_description', 'bookings.*', 'turns.*')->where('user_id', Auth::user()['id'])->where('cancelled', false)->whereDate('turns.date', '>=', Carbon::now())->orderBy('turns.date', 'DESC')->orderBy('turns.start', 'DESC')->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Turn $turn)
    {

        // from('tables')
        //                 ->selectRaw('COALESCE(SUM(maxNumber * quantity), 0)')
        //                 ->whereNotIn('tables.id', function ($subquery) {
        //                     $subquery->from('bookings')
        //                         ->select('bookings.table_id')
        //                         ->whereColumn('turns.id', 'bookings.turn_id')
        //                         ->distinct();
        //                 });
        //         },

        // $turns = Turn::whereDate('date', '>', Carbon::now()->addDays($minBookingDays))
        //     ->doesntHave('bookings')
        //     ->orWhereHas('bookings', function ($subQuery) use ($maxGuestsTurn, $tablesCount) {
        //         $subQuery->havingRaw('SUM(guests) < ?', [$maxGuestsTurn])->havingRaw('COUNT(*) < ?', [$tablesCount]);
        //     })->paginate(15);

        // $tables = Table::doesntHave('bookings')
        //     ->orWhereHas('bookings', function ($subQuery) {
        //         $subQuery->havingRaw('SUM(guests) < ?', [$maxGuestsTurn])->havingRaw('COUNT(*) < ?', [$tablesCount]);
        //     });

        $tables = Table::all();

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
            'guests' => ['required', 'numeric', 'min:1'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $selectedTableId = $request->input('table_id');
        $selectedTable = Table::select('maxNumber', 'minNumber')->find($selectedTableId);

        // Validar si quedan de ese tipo de mesa

        $guests = $request->input('guests');

        if (($selectedTable['maxNumber'] < $guests) || ($selectedTable['minNumber'] > $guests)) {
            return back()->withInput()->withError("Debes seleccionar una mesa habilidata para $guests comensales");
        }

        $minBookingDays = Session::get('minDiasReserva');

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

        $turnGuests = Booking::where('turn_id', $selectedTurnId)->sum('guests');

        $maxGuestsTurn = Session::get('maxComensalesTurno');

        if (($turnGuests + $guests) > $maxGuestsTurn) {
            return back()->withInput()->withError("El aforo está al máximo en este turno");
        }

        $request->merge([
            'user_id' => Auth::user()['id'],
        ]);

        Booking::create($request->all());

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
        $minBookingDays = Session::get('minDiasReserva');
        $maxGuestsTurn = Session::get('maxComensalesTurno');

        $turns = Turn::select('turns.*')
            ->whereDate('date', '>', Carbon::now()->addDays($minBookingDays))
            ->selectSub(
                function ($query) use ($maxGuestsTurn) {
                    $query->from('bookings')
                        ->selectRaw('? - COALESCE(SUM(guests), 0)', [$maxGuestsTurn])
                        ->whereColumn('turns.id', 'bookings.turn_id');
                },
                'turn_remaining_guests'
            )
            ->selectSub(
                function ($query) {
                    $query->from('tables')
                        ->selectRaw('COALESCE(SUM(maxNumber * quantity), 0)')
                        ->whereNotIn('tables.id', function ($subquery) {
                            $subquery->from('bookings')
                                ->select('bookings.table_id')
                                ->whereColumn('turns.id', 'bookings.turn_id')
                                ->distinct();
                        });
                },
                'tables_remaining_guests'
            )
            ->havingRaw('turn_remaining_guests > 0 AND tables_remaining_guests > 0')
            ->paginate(15);

        $turns = Turn::select('turns.*')
            ->whereDate('date', '>', Carbon::now()->addDays($minBookingDays))
            ->selectSub(
                function ($query) use ($maxGuestsTurn) {
                    $query->from('bookings')
                        ->selectRaw('? - COALESCE(SUM(guests), 0)', [$maxGuestsTurn])
                        ->whereColumn('turns.id', 'bookings.turn_id');
                },
                'turn_remaining_guests'
            )
            ->havingRaw('turn_remaining_guests > 0 AND tables_remaining_guests > 0')
            ->paginate(15);

        return view('userbookings.available', ['turns' => $turns]);
    }

    public function cancel(Booking $booking)
    {
        $maxCancelBookingDays = Session::get('maxDiasCancelacionReserva');

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
        return view('userbookings.history', ['userbookings' => Booking::join('turns', 'bookings.turn_id', '=', 'turns.id')->select('bookings.id as booking_id', 'bookings.description as booking_description', 'bookings.*', 'turns.*')->where('user_id', Auth::user()['id'])->where('cancelled', true)->orWhereDate('turns.date', '<', Carbon::now())->orderBy('turns.date', 'DESC')->orderBy('turns.start', 'DESC')->paginate(15)]);
    }
}
