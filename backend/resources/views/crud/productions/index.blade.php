<!-- productions/index.blade.php -->
@extends('layouts.template')

@section('content') 
 <div class="container-fluid pt-4 px-4" >
  
    <div class="row g-4">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createProductionModal">Adicionar Nova Produção</button>
       
        @foreach($productions as $production)
        <div class="col-md-4">
            <div class="h-50 bg-secondary rounded p-4">
                <a href="{{ route('productions.show', $production->id) }}">
                   
                    <div class="d-flex align-items-center border-bottom py-3">
                       <img src="{{ asset($production->image) }}" alt="{{ $production->name }}" class="rounded-circle" style="max-width: 40%; height: auto; display: block; margin: 0 auto;"  onerror="this.src='/darkpan/img/logo.png'">
                       <h6 class="mb-0">{{ $production->name }}</h6>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
        
</div>
    
<!-- Modal de criação de produção -->
<div class="modal fade " id="createProductionModal" tabindex="-1" aria-labelledby="createProductionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg  form-gategun ">
        <div class="modal-content  bg-secondary form-gategun text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="createProductionModalLabel">Adicionar Nova Produção</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body ">
                <!-- Formulário de criação de produção -->
                <form method="POST" action="{{ route('productions.store') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Campos do formulário de criação de produção -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome da Produção</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Localização</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Logo da Produção</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>
                    <!-- Adicione mais campos da produção conforme necessário -->
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
                
            </div>
        </div>
    </div>
</div>

@endsection
