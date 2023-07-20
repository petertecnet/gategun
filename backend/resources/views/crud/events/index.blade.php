@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $event->name }}</div>

                <div class="card-body">
                    <p><strong>Descrição:</strong> {{ $event->description }}</p>
                    <p><strong>Data:</strong> {{ $event->date }}</p>
                    <p><strong>Horário:</strong> {{ $event->time }}</p>
                    <p><strong>Local:</strong> {{ $event->location }}</p>
                    <p><strong>Preço:</strong> R$ {{ number_format($event->price, 2, ',', '.') }}</p>
                    <p><strong>Nome do Produtor:</strong> {{ $event->producerName() }}</p>

                    <div>
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" style="max-width: 100%; height: auto;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
