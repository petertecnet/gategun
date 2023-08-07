<!-- productions/index.blade.php -->
@extends('layouts.template')

@section('content') 
 <div class="container-fluid pt-4 px-4" >
  
    <div class="row g-4">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createProductionModal">Adicionar Nova Produção</button>

@if($productions && count($productions) > 0)    
        @foreach($productions as $production)
        <div class="col-md-4">
            <div class="h-50 bg-secondary rounded p-4">
                <a href="{{ route('productions.show', $production->id) }}">
                   
                    <div class="d-flex align-items-center border-bottom py-3">
                       <img src="{{ asset($production->image) }}" alt="{{ $production->name }}" class="rounded-circle" style="max-width: 40%; max-heid: 40%; height: auto; display: block; margin: 0 auto;"  onerror="this.src='/darkpan/img/logo.png'">
                       <h6 class="mb-0">{{ $production->name }}</h6>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
        @else <div class="col-md-4">
                   
            <p class="text-center text-gategun">Cadastre sua produção para divulgar um evento</p>
                      <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#createProductionModal">Adicionar Nova Produção</button>
   
                    </div>
            </div>
        </div>
        
        @endif

    
<!-- Modal de criação de produção -->
<div class="modal fade " id="createProductionModal" tabindex="-1" aria-labelledby="createProductionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl  form-gategun ">
        <div class="modal-content  bg-secondary form-gategun text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="createProductionModalLabel">Adicionar Nova Produção</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body ">
                <!-- Formulário de criação de produção -->
                <form method="POST" action="{{ route('productions.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nome da Produção</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label">Tipo de produção</label>
                            <select class="form-select" id="type" name="type" required>
                                
                                <option value="espaço">Espaço</option>
                                <option value="coletivo">Coletivo</option>
                                <option value="festival">Festival</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="image" class="form-label">Imagem</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                            <small class="form-text text-muted">Faça upload de uma imagem para a produção.</small>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="description" class="form-label">Descrição da Produção</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="location" class="form-label">Localização</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <div class="col-md-6">
                            <label for="address" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                    </div>
                    
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label">Preço</label>
                            <input type="number" class="form-control" id="price" name="price" >
                        </div>
                        <div class="col-md-6">
                            <label for="capacity" class="form-label">Capacidade</label>
                            <input type="number" class="form-control" id="capacity" name="capacity" required>
                        </div>
                    </div>
                    
                    
                    <button type="submit" class="btn btn-primary mt-3">Salvar</button>
                    
                </form>
                    
                
            </div>
        </div>
    </div>
</div>

@endsection
