@csrf
@method('PUT')

<div class="row">
    <div class="col-md-6">
        <label for="name" class="form-label">Nome da Produção</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $production->name }}" required>
    </div>
    <div class="col-md-6">
        <label for="type" class="form-label">Tipo de Produção</label>
        <select class="form-select" id="type" name="type" required>
            <option value="festival" {{ $production->type === 'festival' ? 'selected' : '' }}>Festival</option>
            <option value="espaço" {{ $production->type === 'espaço' ? 'selected' : '' }}>Espaço</option>
            <option value="coletivo" {{ $production->type === 'coletivo' ? 'selected' : '' }}>Coletivo</option>
        </select>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <label for="description" class="form-label">Descrição da Produção</label>
        <textarea class="form-control" id="description" name="description" rows="4" required>{{ $production->description }}</textarea>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <label for="location" class="form-label">Localização</label>
        <input type="text" class="form-control" id="location" name="location" value="{{ $production->location }}" required>
    </div>
    <div class="col-md-6">
        <label for="address" class="form-label">Endereço</label>
        <input type="text" class="form-control" id="address" name="address" value="{{ $production->address }}" required>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <label for="image" class="form-label">Imagem</label>
        <input type="file" class="form-control" id="image" name="image">
        <small class="form-text text-muted">Faça upload de uma nova imagem para atualizar a imagem atual.</small>
    </div>
</div>

<button type="submit" class="btn btn-primary mt-3">Salvar</button>