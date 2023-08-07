
<meta charset="utf-8">
<title>
    @if(Route::currentRouteName() === 'events.show')  {{ $event->name }} - {{ $event->date }} - @endif
    @if(Route::currentRouteName() === 'productions.show')  {{ $production->name }} - @endif
    Gategun: A solução perfeita para gerenciamento de eventos
</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="
    @if(Route::currentRouteName() === 'events.show')  {{ $event->description }} - @endif
    @if(Route::currentRouteName() === 'productions.show')  {{ $production->name }} - @endif 
    Gategun é uma solução de gerenciamento de eventos poderosa e fácil de usar que permite criar e gerenciar eventos, vender ingressos, coletar pagamentos e se comunicar com os participantes."
>
<meta name="keywords" content="gategun, gerenciamento de eventos, eventos, ingressos, pagamento, comunicação,
    @if(Route::currentRouteName() === 'events.show') {{ $event->name }} - {{ $event->description }} - {{ $event->date }} - {{ $event->production_name }}@endif
    @if(Route::currentRouteName() === 'productions.show')  {{ $production->name }} - @endif 
">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<!-- Favicon -->
<link href="{{ asset('darkpan/img/logo.png') }}" rel="icon">
<!-- Google Web Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
<!-- Icon Font Stylesheet -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
<!-- Libraries Stylesheet -->
<link href="{{ asset('darkpan/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
<link href="{{ asset('darkpan/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
<!-- Customized Bootstrap Stylesheet -->
<link href="{{ asset('darkpan/css/bootstrap.min.css') }}" rel="stylesheet">

<!-- Template Stylesheet -->
<link href="{{ asset('darkpan/css/style.css') }}" rel="stylesheet">