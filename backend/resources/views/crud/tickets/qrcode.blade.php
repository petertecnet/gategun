@extends('layouts.template')

@section('content')

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
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">  
            <div class="col-md-12">
                <div class="bg-secondary rounded p-4 d-flex flex-column align-items-center justify-content">
                    <img src="{{ $qrCodeUrl }}" alt="QR Code" class="qr-img">
                    <hr>
                    <button class="btn btn-primary" onclick="copyToClipboard()">Copiar QR Code</button>
                    <hr>
                    <p class="text-center"> {{ $qrCode }}</p>
                    <p id="copyMessage" style="display: none;">Código copiado para a área de transferência!</p>
                    <hr>
                    <p>ID do Pedido: {{ $idorder }}</p>
                    <hr>
           
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
        function copyQrCodeText() {
        // Obtém o texto do QR Code (URL da imagem)
        const qrCode = document.getElementById('qrCode').value;

        // Cria um elemento temporário para copiar o texto
        const tempElement = document.createElement('textarea');
        tempElement.value = qrCode;
        document.body.appendChild(tempElement);

        // Seleciona o texto no elemento temporário
        tempElement.select();
        tempElement.setSelectionRange(0, 99999); // Para dispositivos móveis

        // Executa o comando de cópia
        document.execCommand('copy');

        // Remove o elemento temporário
        document.body.removeChild(tempElement);

        // Exibe a mensagem de que foi copiado
        const copyMessageElement = document.getElementById('copyMessage');
        copyMessageElement.style.display = 'block';

        // Oculta a mensagem após 3 segundos
        setTimeout(() => {
            copyMessageElement.style.display = 'none';
        }, 3000);
    }
       function copyToClipboard() {
        // Obtém o texto do QR Code (URL da imagem)
        const qrCodeText = "{{ $qrCode }}";

        // Cria um elemento temporário para copiar o texto
        const tempElement = document.createElement('textarea');
        tempElement.value = qrCodeText;
        document.body.appendChild(tempElement);

        // Seleciona o texto no elemento temporário
        tempElement.select();
        tempElement.setSelectionRange(0, 99999); // Para dispositivos móveis

        // Executa o comando de cópia
        document.execCommand('copy');

        // Remove o elemento temporário
        document.body.removeChild(tempElement);

        // Exibe a mensagem de que foi copiado
        const copyMessageElement = document.getElementById('copyMessage');
        copyMessageElement.style.display = 'block';

        // Oculta a mensagem após 3 segundos
        setTimeout(() => {
            copyMessageElement.style.display = 'none';
        }, 3000);
    }
   
async function statusMessageOk() {
    const cartItemsElement = document.getElementById('statusMessage');
    cartItemsElement.innerHTML = '<p class="text-success">Pagamento efetuado!</p>'; // Clear the current content
}
async function statusMessageCheck() {
    const cartItemsElement = document.getElementById('statusMessage');
    cartItemsElement.innerHTML = '<p class="text-primary">Verificando!</p>'; // Clear the current content
}
      
        async function checkPaymentStatus() {
        const orderId = "{{ $idorder }}";

        const cartItemsElement = document.getElementById('statusMessage');
    cartItemsElement.innerHTML = '<p class="text-white">Verificando!</p>'; // Clear the current content
        try {
            const response = await fetch(`/cart/checkPaymentStatus/${orderId}`);
            const data = await response.json();
            const statusMessage = document.getElementById('statusMessage');
            setTimeout(statusMessageCheck, 5500);
            if (data.status === 'paid') {
                
                statusMessage.textContent = 'Pagamento Efetuado';
                setTimeout(statusMessageOk, 3000);
                // Redirecionar para a página de ingressos do usuário
                window.location.href = '/tickets';
            } else if (data.status === 'pending') {
    cartItemsElement.innerHTML = '<p class="text-danger">Aguardando pagamento!</p>'; // Clear the current content
                // Verifica o status de pagamento a cada 5 segundos
                setTimeout(checkPaymentStatus, 500);
            } else if (data.status === 'paid') {
                statusMessage.textContent = 'Pagamento efetuado';
                // Verifica o status de pagamento a cada 5 segundos
                setTimeout(checkPaymentStatus, 500);
            } else {
                statusMessage.textContent = data.status;
                // Verifica o status de pagamento a cada 5 segundos
                setTimeout(checkPaymentStatus, 500);
            }
        } catch (error) {
            console.error('Erro ao verificar status de pagamento:', error);
        }
        
    }

    // Chama a função checkPaymentStatus assim que a página for carregada
    window.addEventListener('load', checkPaymentStatus);
    setTimeout(checkPaymentStatus, 5000);
    </script>
@endsection
