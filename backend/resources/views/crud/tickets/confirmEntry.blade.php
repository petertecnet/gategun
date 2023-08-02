@extends('layouts.template')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-secondary rounded text-white p-4 d-flex flex-column align-items-center justify-content ">
                <!-- Exibir informações do ingresso aqui, se necessário -->
                <h1>Confirmar Registro de Entrada</h1>
                <p>Você deseja registrar a entrada do participante?</p>
                <!-- Formulário para confirmar o registro de entrada -->
                <form action="{{ route('productions.confirmEntry') }}" method="post">
                    @csrf
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                    <button type="submit" class="btn btn-success">Sim, Registrar Entrada</button>
                    <a href="{{ route('tickets.myOne', $ticket->id) }}" class="btn btn-danger">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
