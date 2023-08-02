@extends('layouts.template')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-secondary rounded text-white p-4 d-flex flex-column align-items-center justify-content">
                @if ($ticket->event && $ticket->event->production && $ticket->event->production->image)
                <img src="{{ asset($ticket->event->production->image) }}" alt="{{ $ticket->event->production->name }}" class="card-img-top img-event-sm-gategun rounded-circle" onerror="this.src='/darkpan/img/logo.png'">
            @else
                <!-- Add a fallback image or handle the case when the image is missing -->
                <img src="/darkpan/img/logo.png" alt="Fallback Image">
            @endif
              <h1><a href="{{ route('events.show', $ticket->event->id) }}">{{ $ticket->event->name }}</a></h1>
                <h6><a href="{{ route('productions.show', $ticket->event->production->id) }}" class="text-info">{{ $ticket->event->production->name }}</a></h6>
                {{ $ticket->event->date }}
                <p><strong>ID:</strong> {{ $ticket->id }}</p>
                @if ($isUsed)
                    <p>Este ingresso já foi utilizado.</p>
                @else
                    <p>Este ingresso ainda não foi utilizado.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-light rounded p-4 d-flex flex-column align-items-center justify-content">
                <img src="{{ $apiUrl }}" alt="QR Code" class="img-fluid">
            </div>
        </div>
    </div>
</div>
@endsection
