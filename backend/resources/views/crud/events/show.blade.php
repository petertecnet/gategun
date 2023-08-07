@extends('layouts.template')

@section('content')
<div class="container">
<div class="event-page" >
    <div class="container pt-4 event-content">
        <div class="row">
            <div class="col-md-7">
                <div class="image-container rounded-circle mb-4">
                    <img src="{{ asset($event->image) }}" alt="{{$event->name}}" class="img-fluid">
                </div>
                <h2 class="text-white mb-4" style="font-family: 'Montserrat', sans-serif;">{{$event->name}}</h2>
            </div> 
            <div class="col-md-5 bg-dark">
                <p class="text-light">By:</p><small>{{$event->production->name}}</small>
                <hr>
                <p class="text-light mb-2">
                    <i class="fa fa-calendar-alt me-2" aria-hidden="true"></i>
                    {{ \Carbon\Carbon::parse($event->date)->translatedFormat('l j M') }} das
                    {{ \Carbon\Carbon::parse($event->time)->format('H:i') }}
                    às {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                </p>
                <hr>
                <p class="mb-2">
                    <i class="fa fa-map-marker me-2" aria-hidden="true"></i>
                    {{$event->production->name}}
                </p>
                <hr>
                <a href="{{$event->location}}" class="btn btn-sm btn-info">MAPA</a>
                <hr>
                <a href="#EventTickets" class="btn btn-primary">Comprar Ingresso</a>
                <hr>

                @if(Auth::user()->id == $event->production->user_id)
                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm mt-3">Editar</a>
                <hr class="text-info">
                @endif
            </div>
        </div>
    </div>
</div>
</div>   
        
<div class="container">
    <div class="row">
        <div class="col-md-7 bg-dark">
            <h4>Ingressos</h4>
    
            @foreach ($event->tickets as $ticket)
            <div class="col-md-8 bg-dark ticket-column" style="background-image: url({{ asset($event->image) }}); background-size: cover; background-position: center;">
      
                <div class="ticket-content" >
                    <h4 class="text-dark "> {{ $ticket->name }} </h4>
                    <hr>
                    <h6 class="text-dark">{{$ticket->description}}</h6>
                    <h3 class="text-primary mt-6" style="">R$ {{ $ticket->price }} </h3>
                    <div class="d-flex justify-content-end align-items-center ticket-bottons" >
                        <button type="button" class="btn btn-sm btn-primary me-1 btn-left" onclick="changeQuantity('{{ $ticket->id }}', -1)">-</button>
                        <p data-quantity="0" class="quantityFilde me-1" id="quantityInput-{{ $ticket->id }}">0</p>
                        <button type="button" class="btn btn-sm btn-primary btn-right" onclick="changeQuantity('{{ $ticket->id }}', 1)">+</button>
                    </div>
                </div>
            </div>
            @endforeach
                
            <div class="card">
                <div class="card-header">Descrição</div>
                <div class="card-body">{{$event->description}}</div>
                <div class="card-footer">BY: {{$event->production->name}}</div>
              </div>
            </div>     
      
        <div class="col-md-5 bg-dark ">
            <div class="card checkout-column" id="checkoutColumn"  style=" display: none " >
                <div class="card-header"> <button type="button" class="btn btn-dark " onclick="addToCart('{{ $ticket->id }}')" >COMPRAR</button></div>
                <div class="card-body">   <div id="selectedTicketsList" class="checkout-column-body"></div>
                <div class="card-footer">   <div id="total-price" class="total-price"></div></div>
              </div>
            </div>
        </div>
        
        
        
    </div>
        
</div>   
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">  
        <div class="col-md-12">
            <div class="bg-secondary rounded p-4 d-flex flex-column align-items-center justify-content">
                <h4>Produção do evento:  {{$event->name}}</h4>
               
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="container-fluid pt-4 px-4">
       <div class="row">
          <div class="col-md-4 h-100 bg-white rounded d-flex flex-column justify-content-center align-items-center">
             <a href="{{ route('productions.show', $event->production->id) }}">
                 <hr class="text-dark">
                <img src="{{ asset($event->production->image) }}" alt="{{ $event->production->name }}" class="rounded-circle" style="max-width: 80%; max-height: 80%; height: auto; display: block; margin: 0 auto;" onerror="this.src='/darkpan/img/logo.png'">
                <hr class="text-dark">
                <h2 class="text-center text-dark">{{$event->production->name}}</h2>
             </a>
             <hr class="text-danger">
             @if(Auth::user()->id == $event->production->user_id)
             <a href="{{ route('productions.edit', $event->production->id) }}" class="btn btn-warning btn-sm mt-3">Editar</a>
             <hr class="text-info">
             <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addEventModal">Novo Evento</button>
             
             @endif
             <hr class="text-white">
          </div>
          <div class="col-md-4">
          <h4 class="text-" style="font-family: 'Montserrat', sans-serif;">{{$event->production->name}}</h4>
          <hr>
          <p class="text-light mb-2">
          </p>
          <hr>
          <p class="mb-2">
             <i class="fa fa-map-marker me-2" aria-hidden="true"> </i>{{$event->production->address}}
            
          </p>
          <hr>
          <a href="{{$event->production->location}}" class="btn btn-primary btn-sm">MAPA</a>
          
          <hr>
          <p> Proprietário:  {{$event->production->user->name}}
          <hr>
       </div>
       
       <div class="col-md-4">
         <hr class="text-primary">
         <p class="text-center" style="font-family: 'Montserrat', sans-serif;">{{$event->production->description}}</p>
         <hr>
        
         <hr>
      </div>
       </div>
    </div>
 </div>
 <div class="container-fluid pt-4 px-4">
    <div class="row g-4">  
        <div class="col-md-12">
            <div class="bg-secondary rounded p-4 d-flex flex-column align-items-center justify-content">
                <h4>Eventos de {{$event->production->name}}</h4>
               
            </div>
        </div>
    </div>
</div>
 <div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        @if (count($event->production->events) > 0)
            @foreach ($event->production->events as $event)
                <div class="col-md-4 mb-4">
                    <a href="{{ route('events.show', $event->id) }}">
                        <img src="{{ asset($event->image) }}" alt="{{ $event->name }}" class="card-img-top" onerror="this.src='/darkpan/img/logo.png'">
                  
                     </a>
                     <h5 class="card-title text-gategun">{{ $event->name }}</h5>
                            <p class="card-text text-primary">
                              
                <p class="text-light mb-2">
                    <i class="fa fa-calendar-alt me-2" aria-hidden="true"></i>
                    {{ \Carbon\Carbon::parse($event->date)->translatedFormat('l j M') }} das
                    {{ \Carbon\Carbon::parse($event->time)->format('H:i') }}
                    às {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                </p>
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
<script>


function changeQuantity(ticketId, increment) {
  const quantityElement = document.getElementById('quantityInput-' + ticketId);
  let quantity = parseInt(quantityElement.textContent) + increment;

  if (quantity < 0) {
    quantity = 0;
  }

  quantityElement.textContent = quantity;

  updateCheckout();
}
function updateCheckout() {
    const checkoutColumn = document.getElementById('checkoutColumn');
    const selectedTicketsList = document.getElementById('selectedTicketsList');
    const totalElement = document.getElementById('total-price');
    let total = 0;

    selectedTicketsList.innerHTML = ''; // Limpa o conteúdo anterior
    totalElement.innerHTML = ''; // Limpa o conteúdo anterior
    checkoutColumn.style.display = 'none';

    const ticketElements = document.getElementsByClassName('ticket-column');
    for (let i = 0; i < ticketElements.length; i++) {
        const ticketElement = ticketElements[i];
        const quantityElement = ticketElement.querySelector('.quantityFilde');
        const quantity = parseInt(quantityElement.textContent);

        if (!isNaN(quantity) && quantity > 0) {
            const ticketName = ticketElement.querySelector('h4').textContent;
            const ticketPrice = parseFloat(ticketElement.querySelector('h3').textContent.split(' ')[1]);
            const ticketId = ticketElement.getAttribute('data-ticket-id'); // Adicione esse atributo ao elemento .ticket-column no HTML

            const ticketInfo = document.createElement('p');
            ticketInfo.textContent = quantity + 'x ' + ticketName + ' - R$ ' + (quantity * ticketPrice).toFixed(2);
            selectedTicketsList.appendChild(ticketInfo);

            total += quantity * ticketPrice; // Atualiza o valor total

            // Cria um campo oculto para armazenar os detalhes do ingresso selecionado
            const ticketInput = document.createElement('input');
            ticketInput.type = 'hidden';
            ticketInput.name = 'tickets[' + ticketId + ']';
            ticketInput.value = quantity;
            selectedTicketsList.appendChild(ticketInput);
        }
    }

    totalElement.textContent = 'Total: R$' + total.toFixed(2);
    checkoutColumn.style.display = '';
}
window.addEventListener('scroll', function () {
    // Verifica se o tamanho da janela é maior que 767 pixels (o que caracteriza um dispositivo móvel)
    if (window.innerWidth > 767) {
        const checkoutColumn = document.getElementById('checkoutColumn');
        const eventTickets = document.getElementById('EventTickets');
        const description = document.querySelector('.event-description');

        const descriptionOffset = description.offsetTop + description.offsetHeight;
        const eventTicketsOffset = eventTickets.offsetTop + eventTickets.offsetHeight;

        if (window.pageYOffset >= descriptionOffset) {
            checkoutColumn.style.position = 'relative';
            checkoutColumn.style.top = '';
        } else if (window.pageYOffset >= eventTicketsOffset) {
            checkoutColumn.style.position = 'sticky';
            checkoutColumn.style.top = '100px'; /* Define a distância a partir do topo para onde a coluna ficará fixa */
        } else {
            checkoutColumn.style.position = '';
            checkoutColumn.style.top = '';
        }
    }
});


public function buy() {
  // Get the items from the cart
  const items = cart.getItems();

  // Create a JSON object to represent the items
  const body = {
    items
  };

  // Make a POST request to the API to buy the items
  const response = await fetch('/cart/buy', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}' // Substitua esta linha pela sua forma de obter o token CSRF
    },
    body: JSON.stringify(body)
  });

  // Check if the request was successful
  if (response.ok) {
    // Get the QR code from the API
    const qrcode = await response.json();

    // Display the QR code to the user
    document.getElementById('qrcode').innerHTML = qrcode;
  } else {
    console.error('Erro ao comprar os itens:', response.statusText);
  }
}
</script>





@endsection
