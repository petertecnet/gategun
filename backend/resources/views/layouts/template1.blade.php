<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
       
    @if(Route::currentRouteName() === 'events.show')  {{ $event->name }} - {{ $event->date }} - @endif
    @if(Route::currentRouteName() === 'productions.show')  {{ $production->name }} - @endif
  
    Gategun:  A solução perfeita para gerenciamento de eventos
</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="
 @if(Route::currentRouteName() === 'events.show')  {{ $event->description }} - @endif
@if(Route::currentRouteName() === 'productions.show')  {{ $production->name }} - @endif 
Gategun é uma solução de gerenciamento de eventos poderosa e fácil de usar que permite criar e gerenciar eventos, vender ingressos, coletar pagamentos e se comunicar com os participantes."

>
  <meta name="author" content="Bucky Maler">
</head>
<body>

<!-- notification for small viewports and landscape oriented smartphones -->
<div class="device-notification">
    <a class="device-notification--logo" href="#0">
      <img src="global/assets/img/logo.png" alt="Global">
      <p>Global</p>
    </a>
    <p class="device-notification--message">Global has so much to offer that we must request you orient your device to portrait or find a larger screen. You won't be disappointed.</p>
  </div>
  
  <div class="perspective effect-rotate-left">
    <div class="container"><div class="outer-nav--return"></div>
      <div id="viewport" class="l-viewport">
        <div class="l-wrapper">
          <header class="header">
            <a class="header--logo" href="#0">
              <img src="global/assets/img/logo.png" alt="Global" class="logoimg">
            
            </a>
       
          </header>
          <ul class="l-main-content main-content">
     
         @yield('content')
   
        </ul>
    </div>
  </div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="global/assets/js/vendor/jquery-2.2.4.min.js"><\/script>')</script>
<script src="global/assets/js/functions-min.js"></script>
</body>
</html>
