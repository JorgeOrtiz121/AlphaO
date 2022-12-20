<?php

namespace App\Http\Controllers\Reservaciones;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventoResource;
use App\Http\Resources\ReservaResource;
use App\Models\Evento;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $evento=Evento::all();
        return $this->sendResponse(message: 'Event list generated successfully', result: [
            'eventos' => EventoResource::collection($evento),
            
        ]);
    }


    public function indexuser()
    {
        //
        $user=Auth::user();
        $reservas=Reserva::where('user_id',$user->id)->get();
        if(!$reservas->first()){
            return $this->sendResponse(message: 'The client not have a reservation');
        }

        return $this->sendResponse(message: 'Reserv list generated successfully', result: [
            'reservas' => ReservaResource::collection($reservas),
            
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request ,Evento $evento)
    {
        //
        if($evento->cupos==0){
            return $this->sendResponse(message: 'No exist reservs for this event'); 
        }
        $user=Auth::user();
        $reservacion=new Reserva();
        $num=$evento->cupos;
        $evento->cupos=$evento->cupos-1;
        $reservacion->numero=$num;
        $evento->save();
        $reservacion->eventos_id=$evento->id;
        $user->reserva()->save($reservacion);
        return $this->sendResponse(message: 'Event list generated successfully  '.$num); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento)
    {
        //
        return $this->sendResponse(message: 'Reserva-Event details', result: [
            'eventos' => new EventoResource($evento),
        ]);
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reserva $reserva)
    {
        //
        $reserva->delete();
        return $this->sendResponse("Reserv delete succesfully", 200);

    }
}
