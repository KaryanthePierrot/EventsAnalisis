@extends("layouts.main")

@section('title', 'Editando: ' .  $event->title);

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Editando: {{ $event->title }}</h1>

    <form action="/events/update/{{ $event->id }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $event->id }}">
        <div class="form-group">
            <label for="image">Imagem do Evento:</label>
            <input type="file" id="image" name="image" class="form-control-file {{ $errors->has('image') ? 'is-invalid' : '' }}">
            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}" class="img-preview"></img>
        </div>
        <div class="form-group">
            <label for="title">Evento:</label>
            <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" id="title" name="title" placeholder="Nome do evento" value="{{ old('title', $event->title) }}">
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="date">Data do Evento:</label>
            @php
                $eventDateValue = old('date', (isset($event->date) && is_object($event->date) ? $event->date->format('Y-m-d') : ($event->date ?? '')));
            @endphp
            <input type="date" class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}" id="date" name="date" value="{{ $eventDateValue }}">
            @error('date')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="title">Cidade:</label>
            <input type="text" class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" id="city" name="city" placeholder="Local do evento" value="{{ old('city', $event->city) }}">
            @error('city')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="title">O evento é privado?:</label>
            <select name="private" id="private" class="form-control {{ $errors->has('private') ? 'is-invalid' : '' }}">
                <option value="0" {{ old('private', (string)$event->private) === '0' ? 'selected' : '' }}>Não</option>
                <option value="1" {{ old('private', (string)$event->private) === '1' ? 'selected' : '' }}>Sim</option>
            </select>
            @error('private')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="title">Descrição:</label>
            <textarea name="description" id="description" class="form-control"> {{ $event->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="title">Adicione itens de Infraestrutura</label>

            @php
                $eventItems = $event->items ?? [];
            @endphp

            @if(isset($availableItems) && is_array($availableItems))
                @foreach($availableItems as $item)
                    <div class="form-group">
                        <input type="checkbox" name="items[]" value="{{ $item }}" {{ in_array($item, old('items', $eventItems)) ? 'checked' : '' }}> {{ $item }}
                    </div>
                @endforeach
            @else
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Cadeiras" {{ in_array('Cadeiras', old('items', $eventItems)) ? 'checked' : '' }}> Cadeiras
                </div>

                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Open Bar" {{ in_array('Open Bar', old('items', $eventItems)) ? 'checked' : '' }}> Open bar
                </div>

                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Open Food" {{ in_array('Open Food', old('items', $eventItems)) ? 'checked' : '' }}> Open Foods
                </div>

                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Sorteios" {{ in_array('Sorteios', old('items', $eventItems)) ? 'checked' : '' }}> Sorteios
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
        <input type="submit" class="btn btn-primary" value="Editar Evento">
    </form>
</div>
@endsection