@extends('home.TemplateHome')

@section('items')
    <div class="navbar-nav ms-auto">
        {{-- {{ dd($diseases) }} --}}
        <a href="{{ route('informationCrop', ['id' => $crop['id']]) }}" class="nav-item nav-link">Información</a>
        <a href="{{ route('informationSeeds', ['id' => $crop['id']]) }}" class="nav-item nav-link">Semillas</a>
        <a href="{{ route('informationDiseases', ['id' => $crop['id']]) }}" class="nav-item nav-link">Enfermedades</a>
        <a href="{{ route('informationFertilizers', $crop) }}" class="nav-item nav-link">Fertilizantes</a>
    </div>
@endsection

@section('title')
    {{ $crop['name'] }}
@endsection

@section('image')
    <img class="img-fluid animated pulse infinite" src="{{ $crop['image'] }}" alt="">
@endsection

@section('content')
    <section class="page-section bg-primary" id="information">
        <div class="container-fluid how-to-use bg-primary my-5 py-5">
            <div class="container text-white py-5">
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="text-white mb-3"><span class="fw-light text-dark">Enfermedades</span></h1>
                    <p class="text-white mb-4 animated slideInRight">{{ $crop['name'] }}</p>
                </div>

                <div class="mx-auto text-center wow fadeIn table-responsive" data-wow-delay="0.1s"
                    style="max-height: 30rem">
                    <div class="card">
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @isset($diseases)
                                        @foreach ($diseases as $disease)
                                            <tr>
                                                <td class="text-center">
                                                    @if (isset($disease['image']))
                                                        <img src="{{ $disease['image'] }}" alt="{{ $disease['nameCommon'] }}"
                                                            width="300" height="300">
                                                        <br>
                                                        <br>
                                                        <a href="{{ route('informationPesticides', ['crop' => $crop['id'], 'disease' => $disease['id']]) }}"
                                                            class="btn btn-success">
                                                            Consulta los plaguicidas
                                                         </a>

                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($disease['nameCommon']))
                                                        <strong>Nombre: </strong>{{ $disease['nameCommon'] }}<br>
                                                    @endif
                                                    @if (isset($disease['nameScientific']))
                                                        <strong>Nombre científico:
                                                        </strong>{{ $disease['nameScientific'] }}<br>
                                                    @endif
                                                    @if (isset($disease['description']))
                                                        <strong>Descripción: </strong>{{ $disease['description'] }}<br>
                                                    @endif
                                                    @if (isset($disease['diagnosis']))
                                                        <strong>Diagnóstico: </strong>{{ $disease['diagnosis'] }}<br>
                                                    @endif
                                                    @if (isset($disease['symptoms']))
                                                        <strong>Síntomas: </strong>{{ $disease['symptoms'] }}<br>
                                                    @endif
                                                    @if (isset($disease['transmission']))
                                                        <strong>Transmisión: </strong>{{ $disease['transmission'] }}<br>
                                                    @endif
                                                    @if (isset($disease['type']))
                                                        <strong>Tipo: </strong>{{ $disease['type'] }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset



                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
