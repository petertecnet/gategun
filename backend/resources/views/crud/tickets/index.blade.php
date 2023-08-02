@extends('layouts.template')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">  
        <div class="col-md-12">
            <div class="bg-secondary rounded p-4 d-flex flex-column align-items-center justify-content">
                <h4>Meus ingressos:</h4>
               
            </div>
        </div>
    </div>
</div>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">  
        <div class="col-md-12">
            <div class="  bg-secondary p-4"  >
             <div id="ticketList" style=" background-image: url('/darkpan/img/backgroundlogomobile.png');
             background-repeat: no-repeat;
             background-size: cover;
             
       background-position: center center;" >
             </div>
               
            </div>
        </div>
    </div>
</div>
<script>
    // Função para buscar os tickets de ingresso via API
    async function getIngressoTickets() {
        try {
            const response = await fetch('/items');
            const data = await response.json();
            const ticketList = document.getElementById('ticketList');
            ticketList.innerHTML = '';

            // Itera pelos tickets de ingresso e adiciona na lista
            data.forEach(ticket => {
                const ticketItem = document.createElement('div');
                ticketItem.classList.add('col-md-12'); // Defina o tamanho da coluna conforme sua preferência

                ticketItem.innerHTML = `
                    <div class="col-md-12">
                        <div class="card bg-secondary rounded d-flex flex-column">
                            <div class="card bg-ticket-gategun rounded p-4 d-flex flex-column" style="background-position: center center;">
                                <div class="card-body">
                                    <h5 class="card-title">${ticket.name}</h5>
                                    <p class="card-text">
                                        <strong><a href="/events/${ticket.event_id}">Evento</a></strong><br>
                                        <strong>Descrição:</strong> ${ticket.description}<br>
                                        <strong>Status de Utilização:</strong> ${ticket.is_used ? 'Utilizado' : 'Não utilizado'}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Adiciona o evento de clique ao elemento ticketItem
                ticketItem.addEventListener('click', () => {
                    redirectToTicketDetails(ticket.id);
                });

                ticketList.appendChild(ticketItem);
            });

        } catch (error) {
            console.error('Erro ao buscar tickets de ingresso:', error);
        }
    }

    // Função para redirecionar para a página de detalhamento do ingresso
    function redirectToTicketDetails(ingressoId) {
        window.location.href = `/tickets/myOne/${ingressoId}`;
    }

    // Chama a função para buscar os tickets de ingresso assim que a página for carregada
    window.addEventListener('load', getIngressoTickets);

    
</script>

@endsection
