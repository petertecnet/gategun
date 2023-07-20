@extends('layouts.template')

@section('content')
<div class="container-fluid pt-4 px-4">
   
    <div class="row g-4">
         <div class="col">
            
        <div class="h-100 bg-secondary rounded p-4">
            <h3>Descubra Eventos Incríveis</h3>
            <p>Com a Gategun, você tem acesso a uma ampla variedade de eventos incríveis para participar. Navegue pela lista de eventos em diversas categorias, desde shows e festivais até conferências e workshops. Explore novas experiências e encontre os eventos que mais combinam com seus interesses e paixões.</p>
 </div>
</div>
</div>
</div>


<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        
        @if (count($events) > 0)
            @foreach ($events as $event)
              
        <div class="col-md-4">
            <a href="{{ route('events.show', $event->id) }}" class="text-decoration-none">
                <div class="bg-secondary rounded h-100 p-4 d-flex flex-column align-items-center">
                    <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->name }}" style="max-width: 50%; height: auto;">
                    <p class="my-4 text-center  text-gategun">{{ $event->name }}</p>
                    <p class="my-4 text-center text-primary">{{ $event->date }} | R${{ $event->price }} </p>
                    <p class="my-4 text-center text-primary">{{ $event->production_name }}</p>
                </div>
            </a>
        </div>
            @endforeach
        @else
            <p>Nenhum evento cadastrado para este produtor.</p>
        @endif
       
    </div>
@endsection
