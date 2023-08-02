@extends('layouts.template')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        @if ($cart && count($cart->items) > 0)
        <div class="col-md-12">
            <div class="h-100 bg-secondary rounded p-4 d-flex flex-column align-items-center justify-content-center">
                <h4>Total: R$ {{ number_format($cart->getTotalPrice(), 2, ',', '.') }}</h4>
                <a href="{{ route('cart.generateQRCode') }}" class="btn btn-primary">Gerar QR CODE PIX</a>
            </div>
        </div>
        @endif
        <hr>
        <div class="container">
            <div class="col-md-12">
                <div class="h-100 bg-secondary rounded flex-column align-items-center justify-content-center p-4 ">
                    @if ($cart && count($cart->items) > 0)
                    <div class="row">
                        @foreach ($cart->items as $item)
                            <div class="col-md-4">
                                <div class=" bg-ticket-cart-gategun ">
                                    <div class="card-header">
                                        <p>{{ $item['name'] }}</p>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Quantidade:</strong> {{ $item['quantity'] }}</p>
                                        <p><strong>Valor Unitário:</strong> R$ {{ number_format($item['price'], 2, ',', '.') }}</p>
                                        <p><strong>Valor Total:</strong> R$ {{ number_format($item['quantity'] * $item['price'], 2, ',', '.') }}</p>
                                    </div>
                                    <div class="card-footer">
                                        <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="d-flex align-items-right justify-content-right">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="quantity" value="0" class="form-control" style="width: 20px;">
                                            <button type="submit" class="btn btn-sm btn-primary ms-2 align-items-right justify-content-right">
                                                <i class="fa fa-trash"></i> 
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @else
            <div class="col-md-12">
                <div class="h-100 bg-secondary rounded p-4 d-flex flex-column align-items-center justify-content-center">
                    <p>Carrinho vazio.</p>
                </div>
            </div>
        @endif
    </div>
</div>
<script>
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
@endsection
