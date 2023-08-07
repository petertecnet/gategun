@extends('layouts.template')

@section('content')

<div class="container-fluid pt-4 px-4" >
    <div class="swiper-container">
        <div class="swiper-wrapper d-flex">
            @isset($upcomingDates)
            @foreach ($upcomingDates as $date)
                <div class="swiper-slide">
                    <a href="#" class="date-filter" data-date="{{ $date->format('Y-m-d') }}">
                        <div class="date-circle">
                            <span class="date-day">{{ $date->formatLocalized('%d') }}</span>
                        </div>
                        <span class="date-weekday">{{ $date->formatLocalized('%A') }}</span>
                    </a>
                </div>
            @endforeach
            @endisset
        </div>
    </div>
</div>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        @if (count($events) > 0)
            @foreach ($events as $event)
                <div class="col-md-4 mb-4">
                    <a href="{{ route('events.show', $event->id) }}">
                        <img src="{{ asset($event->image) }}" alt="{{ $event->name }}" class="card-img-top" onerror="this.src='/darkpan/img/logo.png'">
                  
                     </a>
                     <h5 class="card-title text-gategun">{{ $event->name }}</h5>
                            <p class="card-text text-primary">
                                {{ $event->date->format('d/m/Y') }} às {{ $event->time }}
                                <p>R$ {{ $event->price }}</p>
                            </p>
                            <a href="{{ route('productions.show', $event->production_id) }}" class="text-dark">{{ $event->production_name }}</a>
                       
                </div>
            @endforeach
        @else
            <div class="col-md-12">
                <p class="text-center text-gategun">Cadastre sua produção para divulgar um evento</p>
                <p class="text-center text-gategun">
                            <a href="/productions/all" class="text-center text-gategun" > Nova produção</a></p>
            </div>
        @endif
    </div>
</div>
@if($events && count($events) > 0)
<script >
    document.addEventListener("DOMContentLoaded", function () {
        // Inicializar swiper.js
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 'auto',
            centeredSlides: true,
            spaceBetween: 20,
        });

        // Capturar o clique na data filtrada
        var dateFilters = document.querySelectorAll(".date-filter");
        dateFilters.forEach(function (filter) {
            filter.addEventListener("click", function (event) {
                event.preventDefault();
                var selectedDate = this.getAttribute("data-date");
                filterEventsByDate(selectedDate);
            });
        });

        // Obter os eventos da view usando json_encode
        var allEvents = @json($events);

        // Função para filtrar os eventos pela data
        function filterEventsByDate(selectedDate) {
            var filteredEvents = allEvents.filter(function (event) {
                var eventDate = new Date(event.date);
                var selected = new Date(selectedDate);

                return (
                    eventDate.getDate() === selected.getDate() &&
                    eventDate.getMonth() === selected.getMonth() &&
                    eventDate.getFullYear() === selected.getFullYear()
                );
            });

            displayFilteredEvents(filteredEvents);
        }

        // Função para exibir os eventos filtrados na página
        function displayFilteredEvents(filteredEvents) {
            var eventsContainer = document.querySelector(".row.g-4");
            eventsContainer.innerHTML = "";

            if (filteredEvents.length > 0) {
                filteredEvents.forEach(function (event) {
                    // Criar e adicionar elementos HTML para exibir os eventos filtrados
                    var eventElement = document.createElement("div");
                    eventElement.classList.add("col-md-4", "mb-4");
                    eventElement.innerHTML = `
                        <div class="card border-0">
                            <a href="{{ route('events.show', $event->id) }}">
                                <img src="{{ asset($event->image) }}" alt="{{ $event->name }}" class="card-img-top" onerror="this.src='/darkpan/img/logo.png'">
                            </a>
                            <div class="card-body bg-secondary">
                                <h5 class="card-title text-gategun">${event.name}</h5>
                                <p class="card-text text-primary">
                                    ${event.date} às ${event.time}
                                    <p>R$ ${event.price}</p>
                                </p>
                            </div>
                            <div class="card-footer border-0 text-center">
                                <a href="{{ route('productions.show', $event->production_id) }}" class="text-dark">${event.production_name}</a>
                            </div>
                        </div>
                    `;

                    eventsContainer.appendChild(eventElement);
                });
            } else {
                // Se não houver eventos filtrados para a data selecionada, exibir mensagem
                var noEventsElement = document.createElement("div");
                noEventsElement.classList.add("col-md-12");
                noEventsElement.innerHTML = `
                    <p class="text-center text-gategun">Cadastre sua produção para divulgar um evento</p>
                    <a href="/productions/all" > Nova produção</a>
                `;

                eventsContainer.appendChild(noEventsElement);
            }
        }
    });
</script>
@endif
@endsection
