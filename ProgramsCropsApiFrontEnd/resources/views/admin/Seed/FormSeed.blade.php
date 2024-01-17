@csrf
<!-- category -->
<div>
    <label class="form-label" for="name">Cultivos:</label>
    <select class="form-control" name="crop_id" id="crop_id">
        <option value="">Seleccione un cultivo</option>

        @isset($crops)
            @foreach ($crops as $crop)
                <option value="{{ $crop['id'] }}"
                    @if (isset($seed) && isset($seed['crop']) && old('crop_id', $seed['crop']['id']) == $crop['id'])
                        selected
                    @elseif (!isset($seed) && old('crop_id') == $crop['id'])
                        selected
                    @endif
                >
                    {{ $crop['name'] }}
                </option>
            @endforeach
        @endisset
    </select>
    @error('crop_id')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- Name-->

<div>
    <label class="form-label" for="name">Nombre:</label>
    <input class="form-control" type="text" name="name" id="name" placeholder="Ingrese el nombre cultivo"
        @isset($seed)
                value="{{ old('name', $seed['name']) }}"
            @endisset>
    @error('name')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>


<!-- NameScientific-->

<div>
    <label class="form-label" for="name">Nombre Científico:</label>

    <input class="form-control" type="text" name="nameScientific" id="nameScientific"
        placeholder="Ingrese el nombre cientifico del cultivo"
        @isset($seed)
            value="{{ old('nameScientific', $seed['nameScientific']) }}"
        @endisset>
    @error('nameScientific')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- Origen -->

<div>
    <label class="form-label" for="origin">Origen:</label>
    <textarea class="form-control" name="origin" id="origin" rows="3" placeholder="Ingrese el origen">
@isset($seed)
{!! old('origin', $seed['origin']) !!}
@endisset
    </textarea>
    @error('origin')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- Morfología -->

<div>
    <label class="form-label" for="morphology">Morfología:</label>
    <textarea class="form-control" name="morphology" id="morphology" rows="3" placeholder="Ingrese la morfología">
@isset($seed)
{!! old('morphology', $seed['morphology']) !!}
@endisset
    </textarea>
    @error('morphology')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- type -->

<div>
    <label class="form-label" for="type">tipo:</label>
    <select class="form-control" name="type" id="type">
        <option value="Criolla"
            @isset($seed)
            @selected(old('type', $seed['type']) == 'Criolla')
        	@endisset>Criolla
        </option>
        <option value="Transgenica"
            @isset($seed)
            @selected(old('type', $seed['type']) == 'Transgenica')
        	@endisset>Transgenica
        </option>
    </select>
    @error('type')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- quality -->

<div>
    <label class="form-label" for="quality">cualidad:</label>
    <select class="form-control" name="quality" id="quality">
        <option value="Sana"
            @isset($seed)
            @selected(old('quality', $seed['quality']) == 'Sana')
        	@endisset>Sana
        </option>
        <option value="Dañada"
            @isset($seed)
            @selected(old('quality', $seed['quality']) == 'Dañada')
        	@endisset>Dañada
        </option>
    </select>
    @error('quality')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- Extensión-->

<div>
    <label class="form-label" for="spreading">Extensión:</label>
    <input class="form-control" type="text" name="spreading" id="spreading"
        placeholder="Ingrese la extensión cultivo"
        @isset($seed)
            value="{{ old('spreading', $seed['spreading']) }}"
        @endisset>
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
<div class="d-flex justify-content-center">
    <img name="image" id="preview-image-before-upload"
        src="@isset($seed){{ asset('storage/seed/' . $seed['image']) }}
    @else
        {{ asset('img/upload-image.png') }}
    @endisset"
        alt="Previsualizar imagen" class="image-preview">
</div>










