@extends('layouts.template')

@section('content')
<div class="container-fluid pt-4 px-4 ">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="h-100 bg-secondary rounded p-4 d-flex flex-column align-items-center justify-content-center">
                <img src="{{ asset('storage/' . $event->image) }}" alt="" class="img-fluid mx-auto d-block rounded ">
            </div>
        </div>
        <hr>

        <!-- Exibindo a lista de ingressos como cards -->
        <h2>Ingressos</h2>

        <!-- Botão para abrir o modal de cadastro de ingresso -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
            Cadastrar Ingresso
        </button>
<hr>
       
        <div class="row"> <!-- Adicione esta div para envolver o loop de ingressos -->
            @if($tickets && count($tickets) > 0)
            @foreach ($tickets as $ticket)
                <div class="col-sm-12 col-md-6 col-xl-4">
                    <div class="h-200 bg-gategun rounded p-5">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <h6 class="mb-0 text-gategunwhite">{{ $ticket->name }}</h6>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-3 ">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 justify-content-center">
                                        <h6 class="text-gategunwhite">{{ 'R$ ' . number_format($ticket->price, 2, ',', '.') }}</h6>
                                    </div>
                                    
                                    <div class="d-flex w-100 justify-content-left ">
                                        <div class="input-group ">
                                            <button type="button" class="btn btn-secondary" onclick="decreaseQuantity()">-</button>
                                            <input id="quantityInput" type="number" class="form-control text-center" value="0" min="0">
                                            <button type="button" class="btn btn-secondary" onclick="increaseQuantity()">+</button>
                                        </div>
                                        
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
        </div> <!-- Feche a div envolvendo o loop de ingressos -->
        
    
    <div class="col-md-12 ">
        <div class="bg-secondary rounded h-200 p-4">
            <iframe
            width="100%"
            height="100%"
            frameborder="0"
            style="border: 0"
            src="https://www.google.com.br/maps?q=72225-509,%20Brasil&output=embed"
            allowfullscreen
        ></iframe>
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