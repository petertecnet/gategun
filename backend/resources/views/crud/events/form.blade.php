 @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <label for="name">Nome do Evento:</label>
            <input type="text" name="name" id="name" value="{{ $event->name }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="location">Local:</label>
            <input type="text" name="location" id="location" value="{{ $event->location }}" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="date">Data:</label>
            <input type="date" name="date" id="date" value="{{ $event->date }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="time">Horário:</label>
            <input type="time" name="time" id="time" value="{{ $event->time }}" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="price">Preço:</label>
            <input type="number" name="price" id="price" value="{{ $event->price }}" step="0.01" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="image">Imagem:</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label for="description">Descrição:</label>
            <textarea name="description" id="description" class="form-control">{{ $event->description }}</textarea>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6 offset-md-3">
            <button type="submit" class="btn btn-primary btn-block">Atualizar Evento</button> 
        </div>
        
    </div>
