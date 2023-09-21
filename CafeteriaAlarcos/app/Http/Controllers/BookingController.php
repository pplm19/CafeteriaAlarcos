<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $request->validate([
                'date' => ['date']
            ]);

            $request->flash();

            $date = $request->input('date');
        } else {
            $request->flush();

            $date = Carbon::now()->toDateString();

            $request->merge(['date' => $date]);

            $request->flash();
        }

        return view('bookings.index', [
            'bookings' => Booking::where('cancelled', false)
                ->whereHas('turn', function ($query) use ($date) {
                    $query->whereDate('date', '=', $date)->orderBy('date', 'DESC')->orderBy('start', 'DESC');
                })
                ->paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

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

    public function cancel(Request $request)
    {
        $request->validate([
            'select' => [
                'required',
                'array',
                Rule::exists(Booking::class, 'id')
            ]
        ]);

        $icategories = $request->input('select');

        foreach ($icategories as $icategory) {
            Booking::find($icategory)->update([
                'cancelled' => true
            ]);
        }

        // return redirect()->route('bookings.index')->withSuccess('¡Reservas canceladas! Los usuarios han sido notificados exitosamente.');
        return redirect()->route('bookings.index')->withSuccess('¡Reservas canceladas! Los registros han sido actualizados exitosamente.');
    }
}
