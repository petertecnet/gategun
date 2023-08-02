@extends('layouts.template')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-secondary rounded text-white p-4 d-flex flex-column align-items-center justify-content">
                <h1>Leitura do QR Code</h1>
                <p>Posicione o QR code do participante dentro da área de leitura abaixo:</p>
                <!-- Área de leitura do QR code (implementar a lógica para ler o QR code aqui) -->
                <div id="qr-reader" style="width: 300px; height: 300px;"></div>
                <br>
                <a href="{{ route('productions.confirmEntry') }}" class="btn btn-success">Confirmar Entrada</a>
                <a href="{{ route('tickets.myOne', $ticket->id) }}" class="btn btn-danger">Cancelar</a>
            </div>
        </div>
    </div>
</div>

<!-- Adicione o script para ler o QR code (utilizando uma biblioteca como QuaggaJS ou ZXing) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
<script>
    // Código JavaScript para ler o QR code utilizando a biblioteca QuaggaJS
    // (Você precisará implementar a lógica para ler o QR code aqui)
</script>
@endsection
