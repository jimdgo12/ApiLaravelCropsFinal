@csrf

<!-- name -->
<div>
    <label class="form-label" for="name">Nombre :</label>
    <input class="form-control" type="text" name="name" id="name" placeholder="Ingrese el nombre del plaguicida"
        @isset($pesticide)
            value="{{ old('name', $pesticide->data->name) }}"
        @endisset>
    @error('name')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- description -->
<div>
    <label class="form-label" for="description">Descripción:</label>
    <input class="form-control" type="text" name="description" id="description"
        placeholder="Ingrese la descripción"
        @isset($pesticide)
            value="{{ old('description', $pesticide->data->description) }}"
        @endisset>
    @error('description')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- activeIngredient -->
<div>
    <label class="form-label" for="activeIngredient">Ingrediente Activo:</label>
    <input class="form-control" type="text" name="activeIngredient" id="activeIngredient"
        placeholder="Ingrese el ingrediente activo"
        @isset($pesticide)
            value="{{ old('activeIngredient', $pesticide->data->activeIngredient) }}"
        @endisset>
    @error('activeIngredient')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- Precio -->
<div>
    <label class="form-label" for="price">Precio:</label>
    <input class="form-control" type="text" name="price" id="price" placeholder="Ingrese el precio"
        value="{{ old('price', $pesticide->data->price ?? '') }}">
    @error('price')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- type -->
<div>
    <label class="form-label" for="type">Tipo plaguicidas:</label>
    <select class="form-control" name="type" id="type">
        <option value="protectante" @selected(old('type', $pesticide->data->type ?? '') == 'protectante')>protectante</option>
        <option value="sistémico" @selected(old('type', $pesticide->data->type ?? '') == 'sistémico')>sistémico</option>
        <option value="Insectos" @selected(old('type', $pesticide->data->type ?? '') == 'Hongos')>Hongos</option>
    </select>
    @error('type')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- dosis -->
<div>
    <label class="form-label" for="dose">Dosis:</label>
    <input class="form-control" type="text" name="dose" id="dose" placeholder="Ingrese la dosis"
        value="{{ old('dose', $pesticide->data->dose ?? '') }}">
    @error('dose')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- image -->
<div>
    <label for="customFile" class="form-label">Imagen:</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" name="image" id="customFile" placeholder="Selecciona una imagen">
        <label class="custom-file-label" for="customFile">Seleccionar</label>
    </div>
    @error('image')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<br>
<div class="d-flex justify-content-center">
    <img name="image" id="preview-image-before-upload"
        src="@isset($pesticide){{ asset('storage/pesticide/' . optional($pesticide->data)->image) }}@else{{ asset('img/upload-image.png') }}@endisset"
        alt="Previsualizar imagen" class="image-preview">
</div>

@isset($pesticide)
    @php
        $disease_ids = collect($pesticide->data->diseases)->pluck('id')->all();
    @endphp
@endisset

<div>
    <label class="form-label" for="disease_ids">Enfermedades: </label>
    @isset($diseases)
        @foreach ($diseases as $disease)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $disease['id'] }}" id="disease_id_{{ $disease['id'] }}" name="disease_ids[]"
                    @if (isset($pesticide) && in_array($disease['id'], $disease_ids)) checked
                    @elseif (is_array(old('disease_ids')) && in_array($disease['id'], old('disease_ids'))) checked
                    @endif>
                <label class="form-check-label" for="disease_id_{{ $disease['id'] }}">{{ $disease['nameCommon'] }} </label>
            </div>
        @endforeach
    @endisset
    @error('disease_ids')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

