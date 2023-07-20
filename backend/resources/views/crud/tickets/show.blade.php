@extends('layouts.template')

@section('content')

            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    
                    <div class="col-md-12">
                        <div class="h-100 bg-secondary rounded p-4 d-flex flex-column align-items-center justify-content-center">
                            <img src="{{ asset($producer->image_url) }}" alt="Imagem do Produtor" class="img-thumbnail circle" style="width: 20%; height: auto;">
                            <h2 class="text-center mt-2">{{ $producer->name }}</h2>
                            <p class="text-center">{{ $ownerName }}</p>
                        </div>
                    </div>
                    
                
                    
    <hr>

    <!-- Exibindo a lista de eventos como cards -->
    <h2>Eventos  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
       Novo
    </button></h2>

              
        @if (count($events) > 0)
        @foreach ($events as $event)
            <div class="col-sm-12 col-md-6 col-xl-4">
                <div class="h-100 bg-secondary rounded p-4">
                    <a href="{{ route('events.show', $event->id) }}">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6 class="mb-0">{{ $event->name }}</h6>
                        </div>
                        <div class="d-flex align-items-center border-bottom py-3">
                            <img class="rounded-circle flex-shrink-0" src="{{ asset('storage/' . $event->image) }}" alt="" style="width: 40px; height: 40px;">
                            <div class="w-100 ms-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-0">{{ $event->date->format('d/m/Y') }}</h6>
                                    <small>
                                        <p class="card-text">às {{ $event->time }}</p>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    @else
        <p>Nenhum evento cadastrado para este produtor.</p>
    @endif
    
            </div>
        </div>

        <div class="modal fade " id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl ">
                <div class="modal-content bg-secondary text-info">
                    <div class="modal-header">
                        <h5 class="modal-title text-info" id="addEventModalLabel">Cadastro de Evento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                                <div class="col-md-10 ">
                                  
                                    <h8 class="text-center"> Mais visibilidade, alcance de público amplo, gestão eficiente, organização e facilidade na divulgação. Funcionalidades: Campos obrigatórios, imagem, registro, edição e exclusão.</h8>
                                     
                                        <h2 class="mb-4 text-info">     {{$producer->name }} - {{$producer->id }}</h2>
                                        <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" id="producer_id" name="producer_id" value="{{ $producer->id  }}">
                                            <input type="hidden" id="producer_name" name="producer_name" value="{{ $producer->name }}">
                                       
                                            <div class="row mb-3">
                                                <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Imagem do Evento') }}</label>
                                                <div class="col-md-6">
                                                    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" required>
                                                    @error('image')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nome do Evento') }}</label>
                                                <div class="col-md-6">
                                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                    
                                            <div class="row mb-3">
                                                <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Descrição') }}</label>
                                                <div class="col-md-6">
                                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="4" required>{{ old('description') }}</textarea>
                                                    @error('description')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                    
                                            <div class="row mb-3">
                                                <label for="date" class="col-md-4 col-form-label text-md-end">{{ __('Data do Evento') }}</label>
                                                <div class="col-md-6">
                                                    <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required>
                                                    @error('date')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                    
                                            <div class="row mb-3">
                                                <label for="time" class="col-md-4 col-form-label text-md-end">{{ __('Horário') }}</label>
                                                <div class="col-md-6">
                                                    <input id="time" type="time" class="form-control @error('time') is-invalid @enderror" name="time" value="{{ old('time') }}" required>
                                                    @error('time')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                    
                                            <div class="row mb-3">
                                                <label for="location" class="col-md-4 col-form-label text-md-end">{{ __('Local') }}</label>
                                                <div class="col-md-6">
                                                    <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location') }}" required>
                                                    @error('location')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                    
                                            <div class="row mb-3">
                                                <label for="price" class="col-md-4 col-form-label text-md-end">{{ __('Preço') }}</label>
                                                <div class="col-md-6">
                                                    <input id="price" type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" required>
                                                    @error('price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                    
                                    
                                            <div class="row mb-3">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Cadastrar Evento') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                  
                                      
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  
<script>
    function openDeleteConfirmationModal(eventId) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = "{{ route('events.destroy', '') }}" + "/" + eventId;
        $('#deleteConfirmationModal').modal('show');
    }
    function openAddEventModal(producerId) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = "{{ route('events.store', '') }}" + "/" + producerId;
        $('#addEventModal').modal('show');
    }
</script>
@endsection
