@extends('admin.BaseAdmin')

@section('title')
    Registrar un Fertilizante
@endsection

@section('content')
    <div class="row">
        <div class="offset-3 col-6">
            <div class="card">
                <div class="card-body">
                    <!-- enctype="multipart/form-data"
                            adjuntar archivos a la petición del formulario
                            adjuntar un archivo de imagen (.jpg, .png)
                        -->
                    <form action="{{ route('fertilizers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('admin.fertilizer.FormFertilizer')
                        {{-- {{ dd($fertilizer) }} --}}
                        <br>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-success" type="submit"> Registrar </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection


@section('scripts')
    <!-- bs-custom-file-input -->
    <script src="{{ asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            bsCustomFileInput.init();
        });
        $(document).ready(function(e) {
            $('#customFile').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image-before-upload').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endsection


