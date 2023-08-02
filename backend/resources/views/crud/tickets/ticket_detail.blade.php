<!-- ticket_detail.blade.php -->
@extends('layouts.template')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">  
        <div class="col-md-12">
            <div class="bg-secondary rounded p-4 d-flex flex-column align-items-center justify-content"
            style="
            background-image: url('/{{$ticket->event->image}}');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;">
          <div class="bg-secondary rounded p-4 d-flex flex-column align-items-center justify-content">
                <h1>{{$user->name}}</h1>
               <h2 class="text-white" >{{$ticket->name}}</h2> 
              
                
          <div class="rounded p-4 d-flex flex-column align-items-center justify-content">
       <h2 class="text-danger" >{{$ticket->event->name}}</h2>     
       </div>
          
          <div class="bg-secondary rounded p-4 d-flex flex-column align-items-center justify-content">
          <form action="{{ route('tickets.capture', ['id' => $ticket->id]) }}" method="post">
            @csrf
            <button type="submit" class="btn btn-md btn-info">Validar Ingresso e Liberar Participante</button>
        </form>
          </div>
            </div>
            </div>
        </div>
    </div>
</div>

@endsection
