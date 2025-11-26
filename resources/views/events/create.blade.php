@extends("layouts.main")

@section('title', 'Produtos')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Crie o seu Evento</h1>

    <form action="/events" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="image">Imagem do Evento:</label>
            <input type="file" id="image" name="image" class="form-control-file {{ $errors->has('image') ? 'is-invalid' : '' }}">
            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="title">Evento:</label>
            <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" id="title" name="title" placeholder="Nome do evento" value="{{ old('title') }}">
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="date">Data do Evento:</label>
            <input type="date" class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}" id="date" name="date" value="{{ old('date') }}">
            @error('date')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="title">Cidade:</label>
            <input type="text" class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" id="city" name="city" placeholder="Local do evento" value="{{ old('city') }}">
            @error('city')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="title">O evento é privado?:</label>
            <select name="private" id="private" class="form-control {{ $errors->has('private') ? 'is-invalid' : '' }}">
                <option value="0" {{ old('private') === '0' ? 'selected' : '' }}>Não</option>
                <option value="1" {{ old('private') === '1' ? 'selected' : '' }}>Sim</option>
            </select>
            @error('private')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="title">Descrição:</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="title">Adicione itens de Infraestrutura</label>

            @if(isset($availableItems) && is_array($availableItems))
                @foreach($availableItems as $item)
                    <div class="form-group">
                        <input type="checkbox" name="items[]" value="{{ $item }}" {{ in_array($item, old('items', [])) ? 'checked' : '' }}> {{ $item }}
                    </div>
                @endforeach
            @else
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Cadeiras" {{ in_array('Cadeiras', old('items', [])) ? 'checked' : '' }}> Cadeiras
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Open Bar" {{ in_array('Open Bar', old('items', [])) ? 'checked' : '' }}> Open bar
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Open Food" {{ in_array('Open Food', old('items', [])) ? 'checked' : '' }}> Open Foods
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Sorteios" {{ in_array('Sorteios', old('items', [])) ? 'checked' : '' }}> Sorteios
                </div>
            @endif

            <span>Adicione mais itens (separe por vírgula):</span>
            <div class="form-group">
                <input type="text" class="form-control {{ $errors->has('new_items') ? 'is-invalid' : '' }}" id="new_items" name="new_items" placeholder="Ex: Som, Palco" value="{{ old('new_items') }}">
                @error('new_items')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <input type="submit" class="btn btn-primary" value="Criar Evento">
    </form>
</div>
@endsection