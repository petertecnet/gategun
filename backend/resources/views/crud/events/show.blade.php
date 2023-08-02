@extends('layouts.template')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">  
        <div class="col-md-12">
            <div class="bg-secondary rounded p-4 d-flex flex-column align-items-center justify-content">
                <h2>{{$event->name}}</h2> 
                  <span>{{ \Carbon\Carbon::parse($event->date)->translatedFormat('l j M') }} das
                    {{ \Carbon\Carbon::parse($event->time)->format('H:i') }}
                    às {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</span>
                    <img class="rounded-circle flex-shrink-0" src="{{ asset($event->production->image) }}" alt="" style="width: 40px; height: 40px;">
                   
                <span>{{$event->production->name}}</span>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid pt-4 px-4">
    <div class="row justify-content-center">
        
        <div class="col-md-8">
            <img src="{{ asset($event->image) }}" alt="" class="img-fluid" onerror="this.src='/darkpan/img/logo.png'">
        </div>
      
        <div class="col-md-4">
            <div class="h-100 bg-secondary rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                     <img class="rounded-circle flex-shrink-0" src="{{ asset($event->production->image) }}" alt="" style="width: 40px; height: 40px;">
                   
                    <p>{{ \Carbon\Carbon::parse($event->date)->translatedFormat('l ') }} </p>
                </div>
                <div class="d-flex align-items-center border-bottom py-3">
                    <div class="w-100 ms-3">
                        <div class="d-flex w-100 justify-content-between">
                        </div>
                        <ul>
                            @foreach ($event->tickets as $ticket)
                                <li>{{ $ticket->name }} - R$ {{ $ticket->price }}
                                    <!-- E outros atributos que você tenha no modelo Ticket -->
                                </li>
                            @endforeach
                        </ul>
                        <br>
                    </div>
                </div>
                <hr>
                
                <span class="text-primary">{{ \Carbon\Carbon::parse($event->date)->translatedFormat('l j M') }} das
                    {{ \Carbon\Carbon::parse($event->time)->format('H:i') }}
                    às {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</span>
                    <hr>
                    
                   <a href="{{$event->production->location}}" class="btn btn-success">  <i class="fa fa-map-marker" aria-hidden="true"></i> Localização</a>
                    
                <hr>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4 d-flex flex-column justify-content">
        <h6>{{ $event->description }}</h6>
        <hr>
    </div>
</div>

<div class="col-md-12">
    <div class="card bg-secondary">
        <div class="card-body">
            @auth
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="h-100 bg-secondary rounded p-4">
                            <form id="commentForm" data-event-id="{{ $event->id }}" action="{{ route('events.storeComment', $event->id) }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <textarea name="comment" id="comment" rows="3" class="form-control"></textarea>
                                </div>
                                <button type="button" class="btn btn-primary" id="submitComment">Enviar Comentário</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endauth

            <div id="commentsContainer">
                <!-- Aqui serão exibidos os comentários -->
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Função para atualizar a lista de comentários
    function updateComments() {
        var eventId = $('#commentForm').data('event-id');
        $.ajax({
            url: '/events/' + eventId + '/getComments',
            type: 'GET',
            success: function (data) {
                // Limpa a lista de comentários existente
                $('#commentsContainer').empty();

                // Adiciona os novos comentários à lista
                data.comments.forEach(function (comment) {
                    var commentHtml = createCommentHtml(comment);
                    $('#commentsContainer').append(commentHtml);
                });
            },
            error: function (xhr) {
                // Tratar erros, caso ocorram
            }
        });
    }

    var colors = ['#ff0000', '#00ff00', '#0000ff', '#ff00ff', '#00ffff', '#ffff00']; // Lista de cores

    function getUserColor(username) {
        // Calcular o índice do usuário com base em seu nome de usuário
        var index = 0;
        for (var i = 0; i < username.length; i++) {
            index += username.charCodeAt(i);
        }
        index %= colors.length;
        return colors[index];
    }

    function formatDate(dateString) {
        // Criar um objeto Date usando a string da data
        var date = new Date(dateString);

        // Formatar a data no padrão desejado (dd/mm/yyyy HH:mm:ss, por exemplo)
        var formattedDate = ('0' + date.getDate()).slice(-2) + ' ' + date.toLocaleString('default', { month: 'short' }) + ' ' + date.getFullYear();
        var hours = ('0' + date.getHours()).slice(-2);
        var minutes = ('0' + date.getMinutes()).slice(-2);
        formattedDate += ' das ' + hours + ':' + minutes;

        return formattedDate;
    }

    function createCommentHtml(comment) {
        var userColor = getUserColor(comment.user.name); // Obter a cor para o usuário
        var commentHtml = '<div class="d-flex align-items-center border-bottom py-3" style="color: ' + userColor + ';">' +
            '<div class="w-100 ms-3">' +
            '<div class="d-flex w-100 justify-content-between">' +
            '<small></small>' +
            '</div>' +
            '<h6>' + comment.user.name + ': ' + comment.comment + '</h6><br><span>ás: ' + formatDate(comment.created_at) + '</span>' +
            '</div>' +
            '</div>';
        return commentHtml;
    }

    $(document).ready(function () {
        // Evento de clique para enviar o formulário de comentário
        $('#submitComment').on('click', function () {
            var eventId = $('#commentForm').data('event-id');
            var comment = $('#comment').val();

            $.ajax({
                url: '/events/' + eventId + '/storeComment',
                type: 'POST',
                data: {
                    comment: comment,
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    // Limpar o campo de comentário
                    $('#comment').val('');

                    // Atualizar a lista de comentários
                    updateComments();
                },
                error: function (xhr) {
                    // Tratar erros, caso ocorram
                }
            });
        });

        // Atualizar a lista de comentários a cada 5 segundos (ou o valor desejado)
        setInterval(function () {
            updateComments();
        }, 1000); // 5 segundos (1000ms = 1 segundo)

        // Chamar a função para atualizar a lista de comentários imediatamente após a página ser carregada
        updateComments();
    });
</script>
<script>
    // Função para atualizar o cronômetro
    function updateCountdown() {
        var eventDateTime = moment("{{ $event->date }} {{ $event->time }}", "YYYY-MM-DD HH:mm"); // Data e hora do evento no formato "ano-dia-mes hora:minuto"
        var now = moment(); // Data e hora atual

        // Verifica se o evento ainda não ocorreu
        if (eventDateTime.isAfter(now)) {
            // Calcula a diferença entre a data do evento e a data atual
            var timeRemaining = eventDateTime.diff(now);

            // Formata a diferença em dias, horas, minutos e segundos
            var duration = moment.duration(timeRemaining);
            var days = duration.days();
            var hours = duration.hours();
            var minutes = duration.minutes();
            var seconds = duration.seconds();

            // Obtém o dia da semana e o nome abreviado do mês do evento
            var dayOfWeek = eventDateTime.format("dddd");
            var dayOfMonth = eventDateTime.format("D");
            var monthAbbr = eventDateTime.format("MMM");

            // Formata a hora de início do evento
            var startTime = eventDateTime.format("HH:mm");

            // Cria a string de exibição do cronômetro
            var countdownStr = dayOfWeek + " " + dayOfMonth + " " + monthAbbr + " das " + startTime;

            // Atualiza o elemento HTML com o cronômetro
            document.getElementById("countdown").innerHTML = "em " + days + " dias, " + hours + " horas, " + minutes + " minutos e " + seconds + " segundos.";
        } else {
            // Se o evento já ocorreu, exibe uma mensagem indicando isso
            document.getElementById("countdown").innerHTML = "O evento já ocorreu!";
        }
    }

    // Atualiza o cronômetro a cada segundo
    setInterval(updateCountdown, 1000); // 1000 milissegundos = 1 segundo

    // Chama a função para atualizar o cronômetro imediatamente após a página ser carregada
    updateCountdown();
</script>

@endsection
