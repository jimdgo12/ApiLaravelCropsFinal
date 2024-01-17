@csrf

<div>
    <label class="form-label" for="name">Nombre:</label>
    <input class="form-control" type="text" name="name" id="name" placeholder="Ingrese el nombre cultivo"
        @isset($crop)
            value="{{ old('name', $crop['name']) }}"
        @endisset>
    @error('name')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- description -->

<div>
    <label class="form-label" for="description">Descripción:</label>
    <textarea class="form-control" name="description" id="description" rows="3" placeholder="Ingrese la descripción">
        @isset($crop)
            {{ old('description', $crop['description']) }}

        @endisset
    </textarea>
    @error('description')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- nameScientific -->

<div>
    <label class="form-label" for="nameScientific">Nombre Científico:</label>
    <input class="form-control" type="text" name="nameScientific" id="nameScientific"
        placeholder="Ingrese el nombre Científico" {{-- value="{{ old('nameScientific', $crop['nameScientific']) }}"> --}}
        @isset($crop)
            value="{{ old('nameScientific', $crop['nameScientific']) }}"
        @endisset>
    @error('breed')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>


<!-- history -->

<div>
    <label class="form-label" for="history">Historía:</label>
    <textarea class="form-control" name="history" id="history" rows="3" placeholder="Ingrese la historía">
        @isset($crop)
{{ old('history', $crop['history']) }}

@endisset
    </textarea>
    @error('history')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>


<!-- phaseFertilizer -->


<div>
    <label class="form-label" for="phaseFertilizer">fases de fertilización:</label>
    <textarea class="form-control" name="phaseFertilizer" id="phaseFertilizer" rows="3"
        placeholder="Ingrese las fases de fertilizacio">
        @isset($crop)
{{ old('phaseFertilizer', $crop['phaseFertilizer']) }}

@endisset
    </textarea>
    @error('phaseFertilizer')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>


<!-- phaseHarvest -->

<div>
    <label class="form-label" for="phaseHarvest">fases de cosecha:</label>
    <textarea class="form-control" name="phaseHarvest" id="phaseHarvest" rows="3" placeholder="Ingrese la cosecha">
        @isset($crop)
{{ old('phaseHarvest', $crop['phaseHarvest']) }}

@endisset
    </textarea>
    @error('phaseHarvest')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>




<!-- spreading -->
<div>
    <label class="form-label" for="spreading">Propagación:</label>
    <select class="form-control" name="spreading" id="spreading">
        <option value="Estaca"
            @isset($crop)
            @selected(old('spreading', $crop['spreading']) == 'Estaca')
        	@endisset>Estaca
        </option>

        <option value="Semilla"
            @isset($crop)
            @selected(old('spreading', $crop['spreading']) == 'Semilla')
        	@endisset>Semilla
        </option>
    </select>

    @error('spreading')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>


<!-- image -->
<div>
    <label for="customFile" class="form-label">Imagen:</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" name="image" id="customFile"
            placeholder="Selecciona una imagen">
        <label class="custom-file-label" for="customFile">Seleccionar</label>
    </div>
    @error('image')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<br>

<!-- Vista previa de la imagen -->
<div class="d-flex justify-content-center">
    <img name="image" id="preview-image-before-upload"
        src="@isset($crop){{ asset('storage/crop/' . $crop['image']) }}@else{{ asset('img/upload-image.png') }}@endisset"
        alt="Previsualizar imagen" class="image-preview">
</div>
