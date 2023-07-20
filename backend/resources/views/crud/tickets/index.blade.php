@extends('layouts.template')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Lista de Produtores</h6>
            <div class="mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createproductionModal">Cadastrar Novo Produtor</button>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Logo</th>
                            <th scope="col">Localização</th>
                            <!-- Adicione mais colunas para os outros atributos, se necessário -->
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productions as $production)
                            <tr>
                                <th scope="row">{{ $production->id }}</th>
                                <td>{{ $production->name }}</td>
                                <td>
                                    <img src="{{ asset($production->image_url) }}" alt="Imagem do Produtor" class="img-thumbnail rounded-circle" style="width: 50px; height: 50px;">
                                </td>
                                <td>{{ $production->location }}</td>
                                <!-- Adicione mais colunas para os outros atributos, se necessário -->
                                <td>
                                    <a href="{{ route('production.show', $production->id) }}" class="btn btn-info">Detalhar Produtor</a>
                                    <button type="button" class="btn btn-dark" onclick="openAddEventModal({{ $production->id }})">Adicionar evento</button>
                                    <button type="button" class="btn btn-danger" onclick="openDeleteConfirmationModal({{ $production->id }})">Excluir</button>
                    
</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="createproductionModal" tabindex="-1" aria-labelledby="createproductionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content bg-secondary ">
            <div class="modal-header">
                <h5 class="modal-title" id="createproductionModalLabel">Cadastro de Produtor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                        <div class="col-md-10">
                          
                                
                                <h2 class="mb-4">Cadastro de Produtor</h2>
                                <form method="POST" action="{{ route('production.store') }}" enctype="multipart/form-data">
                                    @csrf
                                
                                    <div class="row mb-3">
                                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nome') }}</label>
                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                
                                    <div class="row mb-3">
                                        <label for="location" class="col-md-4 col-form-label text-md-end">{{ __('Localização') }}</label>
                                        <div class="col-md-6">
                                            <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location') }}" required autocomplete="location">
                                            @error('location')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                
                                    <div class="row mb-3">
                                        <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Imagem') }}</label>
                                        <div class="col-md-6">
                                            <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" required>
                                            @error('image')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                
                                    <!-- Add more fields as necessary -->
                                
                                    <div class="row mb-3">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Cadastrar Produtor') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                
                                <p class="mb-4">Seja bem-vindo ao cadastro de produtor da Gategun! Aqui você pode registrar todas as informações relevantes sobre os produtores que trabalham conosco.</p>
                                <p class="mb-4">Vantagens de cadastrar o produtor na Gategun:</p>
                                <ul class="mb-4">
                                    <li>Gerencie e acompanhe informações importantes de cada produtor.</li>
                                    <li>Centralize dados sobre a localização dos produtores e suas atividades.</li>
                                    <li>Visualize de forma organizada as imagens e detalhes dos produtores cadastrados.</li>
                                    <li>Obtenha acesso rápido às informações quando necessário.</li>
                                    <!-- Adicione mais vantagens relevantes se desejar -->
                                </ul>
                                <p class="mb-4">Preencha o formulário abaixo para cadastrar um novo produtor na plataforma. Certifique-se de fornecer informações precisas e atualizadas.</p>
                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal de confirmação de exclusão -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary ">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este produtor?</p>
                <p>Essa ação é irreversível e excluirá permanentemente todos os dados associados a este produtor.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
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
