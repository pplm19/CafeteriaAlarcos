<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Turn;
use App\Notifications\MailNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TurnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'date' => ['nullable', 'date']
        ]);

        $data = [
            'turns' => Turn::all()
        ];

        if ($request->has('date')) {
            $data['turnsList'] = Turn::whereDate('date', $request->input('date'))->get();

            $request->flash();

            $date = $request->input('date');
        } else {
            $request->flush();

            $date = Carbon::now()->toDateString();

            $request->merge(['date' => $date]);

            $request->flash();
        }

        return view('turns.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('turns.create', ['turns' => Turn::all(), 'menus' => Menu::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'start' => ['required', 'date_format:H:i'],
            'end' => ['nullable', 'date_format:H:i', 'after:start'],
            'description' => ['nullable', 'string', 'max:255'],
            'menu_id' => ['required', Rule::exists(Menu::class, 'id')]
        ]);

        $turn = Turn::create($request->all());

        return redirect()->route('turns.index', ['search' => true, 'searchDate' => $request->input('date')])->withSuccess("¡Turno creado! Se ha creado satisfactoriamente el turno $turn->name.");
    }

    /**
     * Display the specified resource.
     */
    // public function show(Turn $turn)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Turn $turn)
    {
        return view('turns.edit', ['menus' => Menu::all(), 'turn' => $turn]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Turn $turn)
    {
        if (!blank($request['start'])) {
            $request->merge([
                'start' => Carbon::parse($request['start'])->format('H:i')
            ]);
        }

        if (!blank($request['end'])) {
            $request->merge([
                'end' => Carbon::parse($request['end'])->format('H:i')
            ]);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'start' => ['required', 'date_format:H:i'],
            'end' => ['nullable', 'date_format:H:i', 'after:start'],
            'description' => ['nullable', 'string', 'max:255'],
            'menu_id' => ['required', Rule::exists(Menu::class, 'id')]
        ]);

        $turn->update($request->all());

        return redirect()->route('turns.index', ['search' => true, 'searchDate' => $turn['date']])->withSuccess('¡Turno actualizado! Los cambios se han guardado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'searchDate' => ['nullable', 'date'],
            'select' => [
                'required',
                'array',
                Rule::exists(Turn::class, 'id')
            ]
        ]);

        $turns = $request->input('select');

        try {
            DB::beginTransaction();

            foreach ($turns as $turnId) {
                $turn = Turn::find($turnId);

                if ($turn->bookings()->exists()) {
                    foreach ($turn->bookings()->get() as $booking) {
                        $booking['user']->notify(new MailNotification([
                            'subject' => 'Reserva Cancelada en ' . config('app.name'),
                            'greeting' => 'Estimado/a ' . $booking['user']['name'] . ',',
                            'line' => 'Lamentamos informarle que su reserva el día ' . date('d-m-Y', strtotime($booking['turn']['date'])) . ' en ' . config('app.name') . ' ha sido cancelada debido a que el turno ha sido cancelado.',
                            'action' => ['text' => 'Volver a realizar una reserva', 'url' => route('userbookings.available')],
                            'salutation' => "Sentimos la inconveniencia y esperamos poder servirle en el futuro. \r\n Atentamente, \r\n " . config('app.name'),
                        ]));

                        $booking->tables()->detach();
                        $booking->delete();
                    }
                }

                $turn->delete();
            }

            DB::commit();

            $request->flush();

            return back()->withSuccess('¡Turnos eliminados! Los usuarios han sido notificados exitosamente.');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withError('¡Error! No se pudieron eliminar los turnos seleccionados ya que algunos están vinculados a una o varias reservas.');
        }
    }
}
