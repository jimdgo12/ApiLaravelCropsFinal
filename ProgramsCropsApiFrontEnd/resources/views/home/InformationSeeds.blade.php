@extends('home.TemplateHome')


@section('items')
    <div class="navbar-nav ms-auto">
        {{-- {{ dd($seeds) }} --}}
        <a href="{{ route('informationCrop', ['id' => $crop['id']])}}" class="nav-item nav-link">Información</a>
        <a href="{{ route('informationSeeds', ['id' => $crop['id']]) }}" class="nav-item nav-link">Semillas</a>
        <a href="{{ route('informationDiseases', $crop) }}" class="nav-item nav-link">Enfermedades</a>
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
                    <h1 class="text-white mb-3"><span class="fw-light text-dark">Semillas</h1>
                    <p class="text-white mb-4 animated slideInRight">{{ $crop['name'] }}</p>
                </div>
                <div class="mx-auto text-center wow fadeIn  table-responsive" data-wow-delay="0.1s"
                    style="max-height: 30rem">
                    <div class="card">
                        <div class="card-body table-responsive" data-wow-delay="0.1s" style="max-height: 30rem">
                            <table id="example1" class="table table-striped table-bordered table-hover">


                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- {{ dd($seeds); }} --}}
                                    @isset($seeds)
                                        @foreach ($seeds as $seedGroup)
                                        {{-- {{ dd($seedGroup) }} --}}
                                            @foreach ($seedGroup as $seed)
                                            {{-- {{ dd($seed); }} --}}
                                                <tr>
                                                    <td>
                                                        <img src="{{ asset($seed['image']) }}" alt="{{ $seed['name'] }}" width="300" height="300">
                                                    </td>
                                                    <td>
                                                        <br>
                                                        <br>
                                                        <strong>Nombre: </strong><br>
                                                        {{ $seed['name'] }}<br>
                                                        <strong>Nombre científico: </strong><br>
                                                        {{ $seed['nameScientific'] }}<br>
                                                        <strong>Origen: </strong><br>
                                                        {{ $seed['origin'] }}<br>
                                                        <strong>Morfología: </strong><br>
                                                        {{ $seed['morphology'] }}<br>
                                                        <strong>Tipo: </strong><br>
                                                        {{ $seed['type'] }}<br>
                                                        <strong>Calidad: </strong><br>
                                                        {{ $seed['quality'] }}<br>
                                                        <strong>Propagación: </strong><br>
                                                        {{ $seed['spreading'] }}<br>
                                                        <strong>Imagen: </strong><br>
                                                        {{ $seed['image'] }}<br>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endisset
                                </tbody>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>






    </section>
@endsection
