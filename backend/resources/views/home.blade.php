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
            <div class="col-md-4 mb-4">
                <div class="card border-0 ">
                    <a href="{{ route('events.show', $event->id) }}" >  <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->name }}" class="card-img-top">
                    </a>
                    <div class="card-body bg-secondary">
                        <h5 class="card-title text-gategun">{{ $event->name }}</h5>
                        <p class="card-text text-primary ">
                          
                            {{ $event->date->format('d/m/Y') }} ás {{ $event->time }} 
                            <p>R${{ $event->price }}</p> 
                             
                        </p>
                    </div>
                    <div class=" card-footer border-0 text-center">
                     
                        <a href="{{ route('productions.show', $event->production_id) }}" class="text-dark "> {{ $event->production_name }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-md-12">
            <p class="text-center text-gategun">Nenhum evento cadastrado para este produtor.</p>
        </div>
    @endif
    </div>
@endsection
