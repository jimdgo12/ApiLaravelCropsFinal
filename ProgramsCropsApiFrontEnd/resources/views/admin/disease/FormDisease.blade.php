<!-- crop -->
<!-- nameCommon -->
<div>
    <label class="form-label" for="nameCommon">Nombre Común:</label>
    <input class="form-control" type="text" name="nameCommon" id="nameCommon"
        placeholder="Ingrese el nombre de la Enfermedad"
        @isset($disease)
            value="{{ old('nameCommon', $disease->data->nameCommon) }}"
        @else
            value="{{ old('nameCommon') }}"
        @endisset>

    @error('nameCommon')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- nameScientific -->
<div>
    <label class="form-label" for="nameScientific">Nombre Científico:</label>
    <input class="form-control" type="text" name="nameScientific" id="nameScientific"
        placeholder="Ingrese el nombre científico"
        @isset($disease)
            value="{{ old('nameScientific', $disease->data->nameScientific) }}"
        @else
            value="{{ old('nameScientific') }}"
        @endisset>
    @error('nameScientific')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- description -->
<div>
    <label class="form-label" for="description">Descripción:</label>
    <textarea class="form-control" name="description" id="description" rows="3"
        placeholder="Ingrese la descripción">@isset($disease){{ old('description', $disease->data->description) }}@else{{ old('description') }}@endisset</textarea>
    @error('description')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- diagnosis -->
<div>
    <label class="form-label" for="diagnosis">Diagnóstico:</label>
    <textarea class="form-control" name="diagnosis" id="diagnosis" rows="3"
        placeholder="Ingrese el diagnóstico">@isset($disease){{ old('diagnosis', $disease->data->diagnosis) }}@else{{ old('diagnosis') }}@endisset</textarea>
    @error('diagnosis')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- symptoms -->
<div>
    <label class="form-label" for="symptoms">Síntomas:</label>
    <textarea class="form-control" name="symptoms" id="symptoms" rows="3"
        placeholder="Ingrese los síntomas">@isset($disease){{ old('symptoms', $disease->data->symptoms) }}@else{{ old('symptoms') }}@endisset</textarea>
    @error('symptoms')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- transmission -->
<div>
    <label class="form-label" for="transmission">Transmisión:</label>
    <textarea class="form-control" name="transmission" id="transmission" rows="3"
        placeholder="Ingrese la transmisión">@isset($disease){{ old('transmission', $disease->data->transmission) }}@else{{ old('transmission') }}@endisset</textarea>
    @error('transmission')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- type -->
<div>
    <label class="form-label" for="type">Tipos Enfermedades:</label>
    <select class="form-control" name="type" id="type">
        <option value="Bacterias"
            @isset($disease)
                {{ old('type', $disease->data->type) == 'Bacterias' ? 'selected' : '' }}
            @endisset>Bacterias
        </option>
        <option value="Insectos"
            @isset($disease)
                {{ old('type', $disease->data->type) == 'Insectos' ? 'selected' : '' }}
            @endisset>Insectos
        </option>
        <option value="Hongos"
            @isset($disease)
                {{ old('type', $disease->data->type) == 'Hongos' ? 'selected' : '' }}
            @endisset>Hongos
        </option>
    </select>
    @error('type')
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
        src="@isset($disease){{ asset('storage/disease/' . $disease->data->image) }}@else{{ asset('img/upload-image.png') }}@endisset"
        alt="Previsualizar imagen" class="image-preview">
</div>

@isset($disease)
    @php
        $crop_ids = collect($disease->data->crops)->pluck('id')->all();
    @endphp
@endisset

<div>
    <label class="form-label" for="crop_id">Cultivo: </label>
    @isset($crops)
        @foreach ($crops as $crop)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $crop['id'] }}" id="crop_id_{{ $crop['id'] }}" name="crop_ids[]"
                    @if (isset($disease) && in_array($crop['id'], $crop_ids)) checked
                    @elseif(is_array(old('crop_ids')) && in_array($crop['id'], old('crop_ids'))) checked @endif>

                <label class="form-check-label" for="crop_id_{{ $crop['id'] }}">{{ $crop['name'] }} </label>
            </div>
        @endforeach
    @endisset

    @error('crop_ids')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

