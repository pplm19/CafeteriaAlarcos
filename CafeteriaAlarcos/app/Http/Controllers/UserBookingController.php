<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Table;
use App\Models\Turn;
use App\Notifications\CustomNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return view('userbookings.index', ['userbookings' => Booking::join('turns', 'bookings.turn_id', '=', 'turns.id')->select('bookings.id as booking_id', 'bookings.description as booking_description', 'bookings.*', 'turns.*')->where('user_id', Auth::user()['id'])->whereDate('turns.date', '>=', Carbon::now())->orderBy('turns.date', 'DESC')->orderBy('turns.start', 'DESC')->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'turn_id' => ['nullable', Rule::exists(Turn::class, 'id')],
        ]);

        $minBookingDays = Session::get('minDiasReserva');
        $maxGuestsTurn = Session::get('maxComensalesTurno');
        $tablesCount = Table::sum('quantity');

        $turns = Turn::whereDate('date', '>', Carbon::now()->addDays($minBookingDays))->doesntHave('bookings')->withSum('bookings', 'guests')->orWhereHas('bookings', function ($subQuery) use ($maxGuestsTurn) {
            $subQuery->having('bookings_sum_guests', '<', $maxGuestsTurn);
        })->withCount('bookings')->whereHas('bookings', function ($subQuery) use ($tablesCount) {
            $subQuery->having('bookings_count', '<', $tablesCount);
        })->get();

        $data = [
            'turns' => $turns,
        ];

        if ($request->has('search')) {
            $turnId = $request->input('turn_id');

            $data['tables'] = Table::doesntHave('bookings')->withCount(['bookings' => function ($subQuery) use ($turnId) {
                $subQuery->where('turn_id', $turnId);
            }])->orWhereHas('bookings', function ($subQuery) {
                $subQuery->havingRaw('bookings_count < quantity');
            })->get();

            $request->flash();
        }

        return view('userbookings.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'table_id' => ['required', Rule::exists(Table::class, 'id')],
            'turn_id' => ['required', Rule::exists(Turn::class, 'id')],
            'description' => ['nullable', 'string', 'max:255'],
            'guests' => ['required', 'numeric', 'min:1'],
        ]);

        $selectedTableId = $request->input('table_id');
        $selectedTable = Table::select('maxNumber', 'minNumber')->find($selectedTableId);

        $guests = $request->input('guests');

        if (($selectedTable['maxNumber'] <= $guests) || ($selectedTable['minNumber'] >= $guests)) {
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
        return view('userbookings.history', ['userbookings' => Booking::join('turns', 'bookings.turn_id', '=', 'turns.id')->select('bookings.id as booking_id', 'bookings.description as booking_description', 'bookings.*', 'turns.*')->where('user_id', Auth::user()['id'])->whereDate('turns.date', '<', Carbon::now())->orderBy('turns.date', 'DESC')->orderBy('turns.start', 'DESC')->paginate(15)]);
    }
}
