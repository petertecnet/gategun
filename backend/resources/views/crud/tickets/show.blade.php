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

            <div class="container">
                <div class="row g-4">
                    <!-- Adicione esta div para envolver o loop de ingressos -->
                    @if($tickets && count($tickets) > 0)
                        @foreach ($tickets as $ticket)
                            <div class="col-md">
                                <div class="h-200 bg-gategun rounded p-5">
                                    <div class="d-flex w-100 justify-content-center">
                                        <h6 class="mb-0 text-gategunwhite">{{ $ticket->name }}</h6>
                                    </div>
                                    <div class="d-flex align-items-center border-bottom py-3">
                                        <div class="w-100 ms-3">
                                            <div class="d-flex w-100 justify-content-center">
                                                <h6 class="text-gategunwhite">{{ 'R$ ' . number_format($ticket->price, 2, ',', '.') }}</h6>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <div class="d-flex w-100 justify-content-center">
                                                    <button class="btn btn-sm btn-primary me-2" onclick="decreaseQuantity({{ $ticket->id }})">-</button>
                                                    <input type="number" id="quantityInput-{{ $ticket->id }}" data-price="{{ $ticket->price }}" value="0" class="input-sm-gategun">
                                                    <button class="btn btn-sm btn-primary ms-2" onclick="increaseQuantity({{ $ticket->id }})">+</button>
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
                </div> <!-- Feche a div envolvendo o loop de ingressos -->
            </div>
        </div>
    </div>
    <form action="{{ route('tickets.payment') }}" method="POST">
        @csrf
        <input type="hidden" name="totalvalue" id="totalvalue" value="0"> <!-- Adicionei o input hidden para guardar o valor total da compra -->
    
        <!-- Adicione este input hidden para o nome do ingresso -->
        <input type="hidden" name="ticket_name" id="ticket_name" value="">
    
        <!-- Adicione este input hidden para a quantidade de ingressos solicitada -->
        <input type="hidden" name="ticket_quantity" id="ticket_quantity" value="0">
    
        <!-- Adicione este input hidden para o valor unitário do ingresso -->
        <input type="hidden" name="ticket_unit_price" id="ticket_unit_price" value="0">
    
        <button type="submit" class="btn btn-primary btn-fixed-gategun" id="finalizarCompraBtn">Finalizar compra R$ 0,00</button>
    </form>
    
    <script>
        function increaseQuantity(ticketId) {
            const quantityInput = document.getElementById(`quantityInput-${ticketId}`);
            const quantity = parseInt(quantityInput.value);
            quantityInput.value = quantity + 1;
            updateTotalValue();
        }
    
        function decreaseQuantity(ticketId) {
            const quantityInput = document.getElementById(`quantityInput-${ticketId}`);
            const quantity = parseInt(quantityInput.value);
            if (quantity > 0) {
                quantityInput.value = quantity - 1;
                updateTotalValue();
            }
        }
    
        function updateTotalValue() {
            let totalValue = 0;
            let totalQuantity = 0; // Variável para armazenar a quantidade total de ingressos
    
            const ticketInputs = document.querySelectorAll('[id^="quantityInput-"]');
            ticketInputs.forEach((input) => {
                const quantity = parseInt(input.value);
                const ticketPrice = parseFloat(input.dataset.price);
    
                totalValue += ticketPrice * quantity;
                totalQuantity += quantity; // Atualiza a quantidade total de ingressos
            });
    
            const formattedTotalValue = totalValue.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            document.getElementById('finalizarCompraBtn').innerText = `Finalizar compra ${formattedTotalValue}`;
            document.getElementById('totalvalue').value = totalValue; // Atualiza o valor do input hidden com o valor total da compra
            document.getElementById('ticket_name').value = 'Ingresso'; // Atualiza o valor do input hidden com o nome do ingresso
            document.getElementById('ticket_quantity').value = totalQuantity; // Atualiza o valor do input hidden com a quantidade total de ingressos
            document.getElementById('ticket_unit_price').value = totalValue / totalQuantity; // Atualiza o valor do input hidden com o valor unitário do ingresso
        }
    
        function finalizePurchase() {
            
            // Aqui você pode fazer validações adicionais antes de enviar o formulário, se necessário.
            // O formulário será enviado para a rota de pagamento 'tickets.payment'.
            document.getElementById('finalizarCompraBtn').innerText = 'Processando...'; // Altera o texto do botão para "Processando"
            document.getElementById('finalizarCompraBtn').disabled = true; // Desabilita o botão para evitar cliques repetidos
            document.getElementById('finalizarCompraBtn').form.submit(); // Envia o formulário
        }
    </script>
@endsection
