 @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6">
            <label for="name" class="form-label">Nome da Produção</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $production->name }}" required>
        </div>
        <div class="col-md-6">
            <label for="location" class="form-label">Localização</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ $production->location }}" required>
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

