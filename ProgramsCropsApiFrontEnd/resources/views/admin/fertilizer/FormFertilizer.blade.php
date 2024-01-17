<!-- name -->

<div>
    <label class="form-label" for="name">Nombre :</label>
    <input class="form-control" type="text" name="name" id="name" placeholder="Ingrese el nombre del fertilizante"
        @isset($fertilizer)
            value="{{ old('name', $fertilizer->data->name) }}"
        @endisset>
    @error('name')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- description -->
<div>
    <label class="form-label" for="description">Descripción:</label>
    <input class="form-control" type="text" name="description" id="description"
        placeholder="Ingrese el nombre cientifico"
        @isset($fertilizer)
            value="{{ old('description', $fertilizer->data->description) }}"
        @endisset>
    @error('description')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- dose -->
<div>
    <label class="form-label" for="dose">Dosis:</label>
    <textarea class="form-control" name="dose" id="dose" rows="3" placeholder="Ingrese la dosis">
        @isset($fertilizer)
            {!! old('dose', $fertilizer->data->dose) !!}
        @endisset
    </textarea>
    @error('dose')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- price -->
<div>
    <label class="form-label" for="price">Precio :</label>
    <input class="form-control" type="number" name="price" id="price"
        placeholder="Ingrese el precio del fertilizante"
        @isset($fertilizer)
            value="{{ old('price',$fertilizer->data->price) }}"
        @endisset>
    @error('price')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- type -->
<!-- type -->
<div>
    <label class="form-label" for="type">Tipos fertilizantes:</label>
    <select class="form-control" name="type" id="type">
        <option value="Crecimiento"
            @isset($fertilizer)
                {{ old('type', $fertilizer->data->type) == 'Crecimiento' ? 'selected' : '' }}
            @endisset>Crecimiento
        </option>
        <option value="Desarrollo"
            @isset($fertilizer)
                {{ old('type', $fertilizer->data->type) == 'Desarrollo' ? 'selected' : '' }}
            @endisset>Desarrollo
        </option>
        <option value="Foliar"
            @isset($fertilizer)
                {{ old('type', $fertilizer->data->type) == 'Foliar' ? 'selected' : '' }}
            @endisset>Foliar
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
        src="@isset($fertilizer){{ asset('storage/fertilizer/' . optional($fertilizer)->data->image) }}@else{{ asset('img/upload-image.png') }}@endisset"
        alt="Previsualizar imagen" class="image-preview">
</div>

@isset($fertilizer)
    @php
        $crop_ids = collect($fertilizer->data->crops)->pluck('id')->all();
    @endphp
@endisset

<div>
    <label class="form-label" for="crop_id">Cultivo: </label>
    @isset($crops)
        @foreach ($crops as $crop)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $crop['id'] }}" id="crop_id_{{ $crop['id'] }}" name="crop_ids[]"
                    @if (@isset($fertilizer) && in_array($crop->id, $crop_ids)) checked
                    @elseif (is_array(old('crop_ids')) && in_array($crop->id, old('crop_ids'))) checked
                    @endif>

                <label class="form-check-label" for="crop_id_{{ $crop['id'] }}">{{ $crop['name'] }} </label>
            </div>
        @endforeach
    @endisset

    @error('crop_ids')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<script>
    function previewImage(input) {
        var preview = document.getElementById('preview-image-before-upload');
        var file = input.files[0];
        var reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "{{ asset('img/upload-image.png') }}";
        }
    }
</script>
