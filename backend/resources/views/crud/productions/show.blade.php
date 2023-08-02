@extends('layouts.template')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">

        <div class="col-md-12 ">
            <div class="h-50 bg-dark rounded p-2">
                <a href="{{ route('productions.show', $production->id) }}">
                    
                    <div class="d-flex align-items-center border-bottom py-3">
                        <h4 class="mb-4">{{ $production->name }}</h4>
                        <img class="rounded-circle flex-shrink-0" src="{{$production->image}}" alt="" style="width: 40px; height: 40px;">
                                      
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-6">

            <div class=" bg-secondary rounded p-4">

                <h3 class="mb-3">Eventos de {{ $production->name }} </h3>
                
                <div class="text-center mb-3">
                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addEventModal">Adicionar Novo Evento</button>
                </div>
                @if($production->events && count($production->events) > 0)

                    <ul class="list-group">

                        @foreach($production->events as $event)

                            <li class="list-group-item d-flex justify-content-between align-items-center">

                                <img src="{{ asset($event->image) }}" alt="" class="card-img-top img-event-sm-gategun"  onerror="this.src='/darkpan/img/logo.png'" >
                                {{ $event->name }}
         
                                <div>
                    
                                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-primary btn-sm me-2">Detalhes</a>

                                    @if(Auth::user()->id == $production->user_id)
                                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm">Editar</a>
@endif
                                </div>

                            </li>

                        @endforeach

                    </ul>

                @else

                    <p>Nenhum evento encontrado.</p>

                @endif

            </div>

        </div>

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
