@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class=" col-md- ">
            <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                
                <h2 class="mb-4">Cadastro de Produtor</h2>
                <form method="POST" action="{{ route('producer.store') }}" enctype="multipart/form-data">
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
@endsection
