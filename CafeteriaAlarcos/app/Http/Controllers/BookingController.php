<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Turn;
use App\Models\User;
use App\Notifications\MailNotification;
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
        $request->validate([
            'date' => ['nullable', 'date'],
            'turn' => [
                'nullable',
                Rule::exists(Turn::class, 'id')
            ]
        ]);

        $data = [
            'turns' => Turn::all()
        ];

        if ($request->has(['turn', 'date'])) {
            $request->flash();

            $turn = $request->input('turn');

            $data['turnData'] = Turn::find($turn);
            $data['bookings'] = Booking::where('cancelled', false)->whereHas('turn', function ($query) use ($turn) {
                $query->where('id', '=', $turn);
            })->paginate(15);
        } else {
            $request->flush();

            $date = Carbon::now()->toDateString();

            $request->merge(['date' => $date]);

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

    public function cancel(Request $request)
    {
        $request->validate([
            'select' => [
                'required',
                'array',
                Rule::exists(Booking::class, 'id')
            ]
        ]);

        $bookings = $request->input('select');

        foreach ($bookings as $bookingId) {
            $booking = Booking::find($bookingId);
            $booking->update([
                'cancelled' => true
            ]);
            $booking['user']->notify(new MailNotification([
                'subject' => 'Reserva Cancelada en ' . config('app.name'),
                'greeting' => 'Estimado/a ' . $booking['user']['name'] . ',',
                'line' => 'Lamentamos informarle que su reserva el día ' . date('d-m-Y', strtotime($booking['turn']['date'])) . ' en ' . config('app.name') . ' ha sido cancelada.',
                'action' => ['text' => 'Volver a realizar una reserva', 'url' => route('userbookings.available')],
                'salutation' => "Sentimos la inconveniencia y esperamos poder servirle en el futuro. \r\n Atentamente, \r\n " . config('app.name'),
            ]));
        }

        return redirect()->route('bookings.index')->withSuccess('¡Reservas canceladas! Los usuarios han sido notificados exitosamente.');
    }
}
