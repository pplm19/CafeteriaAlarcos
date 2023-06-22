<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Turn;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'searchDate' => ['nullable', 'date'],
        ]);

        $data = [
            'turns' => Turn::distinct('date')->get('date')
        ];

        if ($request->has('search')) {
            $data['bookings'] = Booking::join('turns', 'bookings.turn_id', '=', 'turns.id')->select('bookings.id as booking_id', 'bookings.description as booking_description', 'bookings.*', 'turns.*')->whereDate('turns.date', $request->input('searchDate'))->orderBy('turns.date', 'DESC')->paginate(15);

            $request->flash();
        }

        return view('bookings.index', $data);
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

    public function cancel(Booking $booking)
    {
        $booking->update([
            'cancelled' => true
        ]);

        return redirect()->route('bookings.index');
    }
}
