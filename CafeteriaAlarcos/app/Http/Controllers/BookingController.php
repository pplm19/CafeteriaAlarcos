<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Turn;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'bookings.index',
            [
                'bookings' => Booking::where('cancelled', false)
                    ->whereHas('turn', function ($query) {
                        $query->whereDate('date', '>=', Carbon::now())->orderBy('date', 'DESC')->orderBy('start', 'DESC');
                    })
                    ->paginate(15)
            ]
        );
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
