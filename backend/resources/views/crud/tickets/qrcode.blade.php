@extends('layouts.template')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">  
            <div class="col-md-12">
                <div class="bg-secondary rounded p-4 d-flex flex-column align-items-center justify-content">
                    <img src="{{ $qrCodeUrl }}" alt="QR Code" class="qr-img">
                    <hr>
                    <button class="btn btn-primary" onclick="copyToClipboard()">Copiar QR Code</button>
                    <hr>
                    <p>ID do Pedido: {{ $idorder }}</p>
                    <hr>
                    <p id="copyMessage" style="display: none;">Código copiado para a área de transferência!</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">  
            <div class="col-md-12">
                <div class="bg-secondary rounded p-4 d-flex flex-column align-items-center justify-content">
                    <h4>Status do Pedido:</h4>
                    <p id="statusMessage">Carregando...</p>
                </div>
            </div>
        </div>
    </div>
 <!-- Modal para exibir mensagem de pagamento realizado -->
 <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Pagamento Realizado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                O pagamento do ingresso foi realizado com sucesso!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
    <script>
        function copyToClipboard() {
            // ... Função copyToClipboard (sem alterações) ...
        }

      
        async function checkPaymentStatus() {
        const orderId = "{{ $idorder }}";

        try {
            const response = await fetch(`/tickets/checkPaymentStatus/${orderId}`);
            const data = await response.json();
            const statusMessage = document.getElementById('statusMessage');
            statusMessage.textContent = data.status;
            if (data.status === 'paid') {
                        // Redirecionar para a página de ingressos do usuário
                        const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
                        paymentModal.show();
                    } else {
                        // Verifica o status de pagamento a cada 5 segundos
                        setTimeout(checkPaymentStatus, 5000);
                    }
        } catch (error) {
            console.error('Erro ao verificar status de pagamento:', error);
        }
    }

    // Chama a função checkPaymentStatus assim que a página for carregada
    window.addEventListener('load', checkPaymentStatus);

    // Verifica o status de pagamento a cada 5 segundos
    setInterval(checkPaymentStatus, 5000);
    </script>
@endsection
