@extends('layouts.template')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-md-12">
                <div class="h-100 bg-secondary rounded p-4 d-flex flex-column align-items-center justify-content-center">
                    <h2 class="text-center mt-2">Ingressos</h2>
                </div>
            </div>
            <hr>
            <div class="container" >
                <div class="row g-4">
                    @if($tickets && count($tickets) > 0)
                        @foreach ($tickets as $ticket)
                            <div class="col-md-4"  >
                                <div class="h-200 bg-ticket-gategun rounded p-5" >
                                    <div class="d-flex w-100 justify-content-center" >
                                        <h6 class="mb-0 text-gategunwhite">{{$ticket->name}} - {{ $ticket->event->name }}</h6>
                                    </div>
                                    <div class="d-flex align-items-center border-bottom py-3">
                                        <div class="w-100 ms-3">
                                            <div class="d-flex w-100 justify-content-center">
                                                <h6 class="text-gategunwhite">{{ 'R$ ' . number_format($ticket->price, 2, ',', '.') }}</h6>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex w-100 justify-content-center">
                                                    <input type="hidden" name="ticket_name" data-ticket-id="{{ $ticket->id }}" value="{{ $ticket->name }}">
                                                  
                                                    <input type="hidden" name="item_price" data-ticket-id="{{ $ticket->id }}" value="{{ $ticket->price }}">
                                                    <input type="hidden" name="item_id" data-ticket-id="{{ $ticket->id }}" value="{{ $ticket->id }}">
                                                    <input type="hidden" name="item_type" data-ticket-id="{{ $ticket->id }}" value="Ingresso">
                                                    <input type="hidden" name="item_description" data-ticket-id="{{ $ticket->id }}" value="{{ $ticket->event->name }}">
                                                    <input type="hidden" name="item_event_id" data-ticket-id="{{ $ticket->id }}" value="{{ $ticket->event->id }}">
                                                    <button type="button" class="btn btn-sm btn-primary me-2" onclick="changeQuantity('{{ $ticket->id }}', -1)">-</button>
                                                    <input type="number" id="quantityInput-{{ $ticket->id }}" name="item_quantity" value="0" class="input-sm-gategun">
                                                    <button type="button" class="btn btn-sm btn-primary ms-2" onclick="changeQuantity('{{ $ticket->id }}', 1)">+</button>
                                                    <button type="button" class="btn btn-sm btn-primary ms-1" onclick="addToCart('{{ $ticket->id }}')">Add</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12">
                            <p>Nenhum ingresso cadastrado para este produtor.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Coloque este script no final da sua página -->
<!-- Restante do seu código da view -->
<!-- Restante do seu código da view -->
<script>
    function changeQuantity(ticketId, value) {
        const quantityInput = document.getElementById(`quantityInput-${ticketId}`);
        const quantity = parseInt(quantityInput.value);
        const newQuantity = Math.max(quantity + value, 0);
        quantityInput.value = newQuantity;
    }

    async function addToCart(ticketId) {
        const quantityInput = document.getElementById(`quantityInput-${ticketId}`);
        const quantity = parseInt(quantityInput.value);

        // Adicione o item ao carrinho somente se a quantidade for maior que 0
        if (quantity > 0) {
            const ticketNameElement = document.querySelector(`input[data-ticket-id="${ticketId}"][name="ticket_name"]`);
            const ticketName = ticketNameElement ? ticketNameElement.value : '';

            const ticketPriceElement = document.querySelector(`input[data-ticket-id="${ticketId}"][name="item_price"]`);
            const ticketPrice = ticketPriceElement ? parseFloat(ticketPriceElement.value) : 0;

            const ticketTypeElement = document.querySelector(`input[data-ticket-id="${ticketId}"][name="item_type"]`);
            const ticketType = ticketTypeElement ? ticketTypeElement.value : '';

const ticketDescriptionElement = document.querySelector(`input[data-ticket-id="${ticketId}"][name="item_description"]`);
const ticketDescription = ticketDescriptionElement ? ticketDescriptionElement.value : '';

const ticketEventIdElement = document.querySelector(`input[data-ticket-id="${ticketId}"][name="item_event_id"]`);
const ticketEventId = ticketEventIdElement ? ticketEventIdElement.value : '';

            // Crie um objeto para representar o ingresso selecionado
            const ticket = {
                item_id: ticketId,
                item_name: ticketName,
                item_price: ticketPrice,
                item_quantity: quantity,
                item_type: ticketType,
                item_description: ticketDescription,
                item_event_id: ticketEventId
            };

            try {
                // Faz uma requisição POST para a rota que adiciona o item ao carrinho usando a API
                const response = await fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Substitua esta linha pela sua forma de obter o token CSRF
                    },
                    body: JSON.stringify(ticket)
                });

                // Verifica se a requisição foi bem-sucedida
                if (response.ok) {
                    // Exibe uma mensagem de sucesso
                    const data = await response.json();
                    console.log(data.message); // Opcional: Exibe a mensagem retornada pelo servidor
                    // Atualiza a lista de itens do carrinho na interface do usuário
                    updateCartItems();
                } else {
                    console.error('Erro ao adicionar item ao carrinho:', response.statusText);
                }
            } catch (error) {
                console.error('Erro ao adicionar item ao carrinho:', error);
            }
        }
    }

    // ... (O restante do seu script para exibir os itens do carrinho)
</script>
<!-- Restante do seu código da view -->
<script>
    // Função para buscar os tickets de ingresso via API
          // Função para atualizar a lista de itens do carrinho e o número de itens no ícone do carrinho
          async function updateCartItems() {
            try {
                // Fetch the cart data from the server
                const response = await fetch('/cart');
            
                // Check if the request was successful
                if (response.ok) {
                    const data = await response.json();
                    const items = data.items;
                
                    // Select the HTML element where the list of items will be displayed
                    const cartItemsElement = document.getElementById('cartItems');
                    const cartIconElement = document.getElementById('cartIcon');
                    cartItemsElement.innerHTML = ''; // Clear the current content
                
                    // Variable to store the total value of all items
                    let totalValue = 0;
                
                    // Create and add HTML elements for each item in the cart
                    items.forEach(item => {
                        const itemElement = document.createElement('div');
                        itemElement.classList.add('dropdown-item');
                        itemElement.innerHTML = `
                            <h6 class="fw-normal mb-0">${item.type}</h6>
                            <small>${item.name}</small>
                            <small>${item.quantity} X R$${item.price.toFixed(2)}</small>
                            <p class="text-danger">R$ ${(item.quantity * item.price).toFixed(2)}</p>
                            <hr>
                        `;
                        cartItemsElement.appendChild(itemElement);
                
                        // Update the total value by adding the value of the current item
                        totalValue += item.quantity * item.price;
                    });
                
                    // Add the total value to the "View All Items" link
                    const viewAllItemsLink = document.createElement('a');
                    viewAllItemsLink.classList.add('dropdown-item', 'text-center');
                    viewAllItemsLink.href = '/cart/viewCart';
                    viewAllItemsLink.textContent = `View Cart: R$ ${totalValue.toFixed(2)}`;
                    cartItemsElement.appendChild(viewAllItemsLink);
                
                    // Update the number of items in the cart icon
                    cartIconElement.textContent = items.length;
                } else {
                    console.error('Error fetching cart items:', response.statusText);
                }
            } catch (error) {
                console.error('Error fetching cart items:', error);
            }
        }
        
        // Chama a função para atualizar a lista de itens assim que a página for carregada
        window.addEventListener('load', updateCartItems);
        
        // Atualiza a lista de itens do carrinho a cada 5 segundos
        setInterval(updateCartItems, 1000);
        
</script>
<!-- Restante do seu código da view -->

@endsection
