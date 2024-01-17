@extends('admin.BaseAdmin')

@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('title')
    Fertilizantes.
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex flex-row align-items-center">
                            <label for="">Cultivos: </label>
                            <select class="form-control form-select" name="crop_id" id="crop_id">
                                <option value="">Seleccione un cultivo</option>

                                @isset($crops)
                                    @foreach ($crops as $crop)
                                        <option value="{{ $crop['id'] }}"
                                            @isset($crop_id)
                                            @selected($crop_id == $crop['id'])
                                        @endisset>
                                            {{ $crop['name'] }}</option>
                                    @endforeach
                                @endisset
                            </select>


                        </div>

                        <div class="d-flex flex-row align-items-center">
                            <a href="{{ route('fertilizers.create') }}" class="btn btn-success">
                                <i class="fas fa-plus-circle nav-icon"> </i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Dosis</th>
                                <th>Precio</th>
                                <th>Tipo</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($fertilizers)
                                @foreach ($fertilizers as $fertilizer)
                                    <tr>
                                        {{-- <td><img src="{{ asset('storage/fertilizer/' . $fertilizer->image) }}" alt="{{ $fertilizer->name }}"
                                                width="60" height="80"></td> --}}
                                        <td><img src="{{ $fertilizer['image'] }}" alt="{{ $fertilizer['name'] }}" width="60"
                                                height="80"></td>
                                        <td>{{ $fertilizer['name'] }}</td>
                                        <td>{{ $fertilizer['description'] }}</td>
                                        <td>{{ $fertilizer['dose'] }}</td>
                                        <td>{{ $fertilizer['price'] }}</td>
                                        <td>{{ $fertilizer['type'] }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('fertilizers.edit', $fertilizer['id']) }}" class="btn btn-info">
                                                <i class="fas fa-edit nav-icon"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('fertilizers.destroy', $fertilizer['id']) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-minus-circle nav-icon"> </i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset

                        </tbody>
                    </table>
                </div>
            </div>
        @endsection

        @section('scripts')
            <!-- DataTables  & Plugins -->
            <script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
            <script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
            <script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
            <script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
            <script src="{{ asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
            <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
            <script src="{{ asset('admin/plugins/jszip/jszip.min.js') }}"></script>
            <script src="{{ asset('admin/plugins/pdfmake/pdfmake.min.js') }}"></script>
            <script src="{{ asset('admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
            <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
            <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
            <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

            <script type="text/javascript">
                $(function() {
                    $("#example1").DataTable({
                        "responsive": true,
                        "lengthChange": true,
                        "autoWidth": true,
                        "language": {
                            "lengthMenu": "Mostrar " +
                                `<select class="custom-select custom-select-sm form-control form-control-sm">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>` +
                                " registros por página",
                            "zeroRecords": "No hay registros",
                            "info": "Mostrando la página _PAGE_ de _PAGES_",
                            "infoEmpty": "No hay registros disponibles",
                            "infoFiltered": "(filtrado de _MAX_ registros totales)",
                            "search": "Buscar:",
                            "paginate": {
                                "next": "Siguiente",
                                "previous": "Anterior"
                            },
                            "processing": "Procesando...",
                            "buttons": {
                                "copy": "Copiar",
                                "print": "Imprimir",
                                "colvis": "Ocultar columnas"
                            }
                        },
                        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

                    var crop = document.getElementById('crop_id');
                    crop.addEventListener('change', function() {
                        var selectOption = this.options[crop.selectedIndex];
                        window.location.href = "/admin/fertilizers/crop/" + selectOption.value;
                    });
                });
            </script>
            @if (session('success'))
                <script>
                    Swal.fire(
                        'Exito!',
                        '{{ session('success') }}',
                        'success'
                    )
                </script>
            @endif

            @if (session('error'))
                <script>
                    Swal.fire(
                        'Error!',
                        '{{ session('error') }}',
                        'error'
                    )
                </script>
            @endif
        @endsection
