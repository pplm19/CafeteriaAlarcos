<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Configuration;
use App\Models\Table;
use App\Models\Turn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserBookingController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'index']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('userbookings.index', ['userbookings' => Booking::join('turns', 'bookings.turn_id', '=', 'turns.id')->select('bookings.id as booking_id', 'bookings.*', 'turns.*')->where('user_id', Auth::user()['id'])->orderBy('turns.date', 'DESC')->orderBy('turns.start', 'DESC')->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $minBookingDays = Configuration::select('value')->where('name', 'minDiasReserva')->first()['value'];

        return view('userbookings.create', ['tables' => Table::all(), 'turns' => Turn::whereDate('date', '>', Carbon::now()->addDays($minBookingDays))->get()]);
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
        ]);

        $configurations = Configuration::whereIn('name', ['minDiasReserva', 'maxComensalesTurno'])->get();

        $minBookingDays = $configurations->firstWhere('name', 'minDiasReserva')['value'];

        $now = Carbon::now();
        $date = Carbon::parse(Turn::select('date')->find($request->input('turn_id'))['date']);

        if ($now > $date) {
            return back()->withInput()->withError("Debes reservar antes de la fecha");
        }

        $days = $date->diffInDays($now);

        if ($days < $minBookingDays) {
            return back()->withInput()->withError("Debes reservar con un mínimo de $minBookingDays días de antelación");
        }

        $maxGuestsTurn = $configurations->firstWhere('name', 'maxComensalesTurno')['value'];

        // [TODO] Overbooking
        $guests = 50;

        if ($guests > $maxGuestsTurn) {
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
    public function destroy(Booking $booking)
    {
        $maxCancelBookingDays = Configuration::select('value')->where('name', 'maxDiasCancelacionReserva')->first()['value'];

        $now = Carbon::now();
        $date = Carbon::parse($booking['turn']['date']);

        if ($now > $date) {
            return back()->withError("Debes cancelar la reserva antes de la fecha");
        }

        $days = $date->diffInDays($now);

        if ($days < $maxCancelBookingDays) {
            return back()->withError("Debes cancelar la reserva con un mínimo $maxCancelBookingDays días de antelación");
        }

        $booking->delete();

        return redirect()->route('userbookings.index');
    }
}
