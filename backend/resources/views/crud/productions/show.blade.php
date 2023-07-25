@extends('layouts.template')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">

        <div class="col-md-6">

            <div class="h-100 bg-secondary rounded p-4">

                <img src="{{ asset($production->image) }}" alt="{{ $production->name }}" style="max-width: 50%; height: auto; display: block; margin: 0 auto;">

                <h2 class="my-4 text-center">{{ $production->name }}</h2>
                <div class="text-center mb-3">
                <a href="{{ $production->location }}" target="_blank" class="btn btn-primary m-2">
               
                    Localização
                </a>
                </div>
                @if(Auth::user()->id == $production->user_id)
                <div class="text-center mb-3">
                    <a href="{{ route('productions.edit', $production->id) }}" class="btn btn-warning">Editar Produção</a>

                 </div>
                @endif
                <div class="text-center mb-3">
                  </div>

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

                                <img src="{{ asset('storage/' . $event->image) }}" alt="" class="card-img-top img-event-sm-gategun" >
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
    <div class="modal-dialog bg-secondary modal-xl">
        <div class="modal-content bg-secondary">
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
