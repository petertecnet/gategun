@extends('layouts.template')
@section('content')
<div class="container">
   <div class="container-fluid pt-4 px-4">
      <div class="row">
         <div class="col-md-4 h-100 bg-white rounded d-flex flex-column justify-content-center align-items-center">
            <a href="{{ route('productions.show', $production->id) }}">
                <hr class="text-dark">
               <img src="{{ asset($production->image) }}" alt="{{ $production->name }}" class="rounded-circle" style="max-width: 80%; max-height: 80%; height: auto; display: block; margin: 0 auto;" onerror="this.src='/darkpan/img/logo.png'">
               <hr class="text-dark">
               <h2 class="text-center text-dark">{{$production->name}}</h2>
            </a>
            <hr class="text-danger">
            @if(Auth::user()->id == $production->user_id)
            <a href="{{ route('productions.edit', $production->id) }}" class="btn btn-warning btn-sm mt-3">Editar</a>
            <hr class="text-info">
            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addEventModal">Novo Evento</button>
            
            @endif
            <hr class="text-white">
         </div>
         <div class="col-md-4">
         <h4 class="text-" style="font-family: 'Montserrat', sans-serif;">{{$production->name}}</h4>
         <hr>
         <p class="text-light mb-2">
         </p>
         <hr>
         <p class="mb-2">
            <i class="fa fa-map-marker me-2" aria-hidden="true"> </i>{{$production->address}}
           
         </p>
         <hr>
         <a href="{{$production->location}}" class="btn btn-primary btn-sm">MAPA</a>
         
         <hr>
         <p> Proprietário:  {{$production->user->name}}
         <hr>
      </div>
      
      <div class="col-md-4">
        <hr class="text-primary">
        <p class="text-center" style="font-family: 'Montserrat', sans-serif;">{{$production->description}}</p>
        <hr>
       
        <hr>
     </div>
      </div>
   </div>
</div>
<div class="container-fluid pt-4">
   <div class="row g-4">
            <h3 class="mb-3">Eventos de {{ $production->name }} </h3>
            <div class="text-center mb-3">
            </div>
            @if($production->events && count($production->events) > 0)
               @foreach($production->events as $event)
               <div class="col-md-4 ">
                <a href="{{ route('events.show', $event->id) }}">
                    <img src="{{ asset($event->image) }}" alt="{{ $event->name }}" class="card-img-top" onerror="this.src='/darkpan/img/logo.png'">
              
                 </a><hr class="text-info">
                 <h5 class="card-title text-gategun">{{ $event->name }}</h5>
                        <p class="card-text text-primary">
                       
                            R$ {{ $event->price }}
                        </p>
                        <p class="text-light mb-2">
                            <i class="fa fa-calendar-alt me-2" aria-hidden="true"></i>
                            {{ \Carbon\Carbon::parse($event->date)->translatedFormat('l j M') }} das
                            {{ \Carbon\Carbon::parse($event->time)->format('H:i') }}
                            às {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                        </p> 
                        @if(Auth::user()->id == $event->production->user_id)
                        <a href="{{ route('productions.edit', $production->id) }}" class="btn btn-warning btn-sm mt-3">Editar</a>
                        <hr class="text-info">
                        @endif 
            </div>
               @endforeach
            @else
            <p>Nenhum evento encontrado.</p>
            @endif
   </div>
</div>
<!-- Modal Adicionar Novo Evento -->
<div class="modal fade " id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
   <div class="modal-dialog bg-secondary modal-xl ">
      <div class="modal-content bg-secondary form-gategun">
         <div class="modal-header">
            <h5 class="modal-title" id="addEventModalLabel">Adicionar Novo Evento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
               @csrf
               <div class="mb-3">
                  <label for="name" class="form-label">Nome do Evento</label>
                  <input type="text" class="form-control" id="name" name="name" required>
               </div>
               <div class="mb-3">
                  <label for="description" class="form-label">Descrição do Evento</label>
                  <textarea class="form-control" id="description" name="description" rows="3"></textarea>
               </div>
               <div class="mb-3">
                  <label for="date" class="form-label">Data do Evento</label>
                  <input type="date" class="form-control" id="date" name="date" required>
               </div>
               <div class="mb-3">
                  <label for="time" class="form-label">Hora do Evento</label>
                  <input type="time" class="form-control" id="time" name="time" required>
               </div>
               <div class="mb-3">
                  <label for="price" class="form-label">Preço do Evento</label>
                  <input type="number" step="0.01" class="form-control" id="price" name="price" required>
               </div>
               <div class="mb-3">
                  <label for="image" class="form-label">Imagem do Evento</label>
                  <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
               </div>
               <input type="hidden" name="location" value="{{ $production->location }}">                  
               <input type="hidden" name="production_id" value="{{ $production->id }}">
               <input type="hidden" name="production_name" value="{{ $production->name }}">
               <button type="submit" class="btn btn-primary">Salvar Evento</button>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
         </div>
      </div>
   </div>
</div>
@endsection
@section('scripts')
<script>
   document.getElementById('deleteModal').addEventListener('shown.bs.modal', function () {
       document.getElementById('deleteProductionButton').focus();
   })
</script>
@endsection