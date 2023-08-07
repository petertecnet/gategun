@extends('layouts.template')
@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card bg-secondary ">
                <div class="card-header "> 
                    <div class="row ">
                    <div class="col-md  p-1">
                        <a href="{{route('productions.show', $event->production_id) }}"><button type="button"
                                class="btn btn-success tet-white aling-right">
                                {{$event->production_name}}</button></a></div>
              
                                <div class="col-md  p-1 ">  <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addEventModal">
                                    Cadastrar Ingresso
                                </button></div>
                             
                    <div class="col-md  p-1 ">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eventCancel">Cancelar evento</button>
  </div>
</div>
</div>
                <div class="card-body">
                   

                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card bg-secondary">
                <div class="card-header">     <a href="{{route('events.show', $event->id) }}"><button type="button"
                                class="btn btn-info tet-white aling-right">
                                {{$event->name}} </button></a></div>
                <div class="card-body">
                    
                    <img src="{{ asset($event->image) }}" alt="" class="card-img-top img-event-sm-gategun " >
              
                    <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        
                        @include('crud.events.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card bg-secondary">
                <div class="card-header">Ingressos </div>
                <div class="card-body">
                
                    @if($tickets && count($tickets) > 0)
                    @foreach ($tickets as $ticket)
                        <div class="col-md-3  p-6 ">
                            <div class="bg-gategun rounded p-6 h-100">
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <h6 class="mb-0 text-gategunwhite">{{ $ticket->name }}</h6>
                                    </div>
                                    <div class="d-flex align-items-center border-bottom py-3 ">
                                        <div class="w-100 ms-3">
                                            <div class="d-flex w-100 justify-content-center">
                                                <h6 class="text-gategunwhite">{{ 'R$ ' . number_format($ticket->price, 2, ',', '.') }}</h6>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                    @else
                        <div class="col-md-12">
                            <p>Nenhum ingresso cadastrado para este produtor.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação -->
<div class="modal fade" id="eventCancel" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
                <h5 class="modal-title text-info" id="deleteModalLabel"> {{$event->name}} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Deseja realmente cancelar  o evento {{$event->name}}?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('events.destroy', $event->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="deleteProductionButton">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal para cadastro de ingresso -->
<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
                <h5 class="modal-title" id="addEventModalLabel">Cadastrar Ingresso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulário para cadastrar o ingresso -->
                <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="event_id" id="event_id" value="{{ $event->id }}">
                    <input type="hidden" name="production_name" id="production_name" value="{{ $event->name }}">
                     <div class="row mb-3">
                        <label for="ticket_type" class="col-md-4 col-form-label text-md-end">{{ __('Tipo de Ingresso') }}</label>
                        <div class="col-md-6">
                            <select id="ticket_type" class="form-control @error('ticket_type') is-invalid @enderror" name="ticket_type" required>
                                <option value="" disabled selected>Selecione o tipo de ingresso</option>
                                <option value="VIP">VIP</option>
                                <option value="Normal">Normal</option>
                                <option value="Estudante">Estudante</option>
                                <!-- Adicione mais opções de acordo com a necessidade -->
                            </select>
                            @error('ticket_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                       <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nome do Ingresso') }}</label>
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
                        <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="name" autofocus>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                    <div class="row mb-3">
                        <label for="quantity" class="col-md-4 col-form-label text-md-end">{{ __('Quantidade de Ingressos Disponíveis') }}</label>
                        <div class="col-md-6">
                            <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}" required>
                            @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="time" class="col-md-4 col-form-label text-md-end">{{ __('Horário limite de entrada') }}</label>
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
                                {{ __('Cadastrar Ingresso') }}
                            </button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
        
    </div>



<script>
    function decreaseQuantity() {
        const inputElement = document.getElementById('quantityInput');
        let currentValue = parseInt(inputElement.value);

        if (currentValue > 0) {
            currentValue--;
            inputElement.value = currentValue;
        }
    }

    function increaseQuantity() {
        const inputElement = document.getElementById('quantityInput');
        let currentValue = parseInt(inputElement.value);

        currentValue++;
        inputElement.value = currentValue;
    }
</script>
@endsection