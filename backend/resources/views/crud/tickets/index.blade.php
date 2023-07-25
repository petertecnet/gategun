@extends('layouts.template')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card bg-secondary">
                <div class="card-header">Ingressos </div>
                <div class="card-body">
                
                    @if($tickets && count($tickets) > 0)
                    @foreach ($tickets as $ticket)
                        <div class="col-md-3  p-6 ">
                            <div class="bg-gategun rounded p-6 h-100">
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <h6 class="mb-0 text-gategunwhite">{{ $ticket->name }}</h6>
                                    </div>
                                    <div class="d-flex align-items-center border-bottom py-3 ">
                                        <div class="w-100 ms-3">
                                            <div class="d-flex w-100 justify-content-center">
                                                <h6 class="text-gategunwhite">{{ 'R$ ' . number_format($ticket->price, 2, ',', '.') }}</h6>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </a>
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
</div>

    
</div>


<!-- Script para abrir o modal de confirmação de exclusão -->
<script>
    function openDeleteConfirmationModal(productionId) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = "{{ route('production.destroy', '') }}" + "/" + productionId;
        $('#deleteConfirmationModal').modal('show');
    }
    function openAddEventModal(productionId) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = "{{ route('events.store', '') }}" + "/" + productionId;
        $('#addEventModal').modal('show');
    }
</script>

@endsection
