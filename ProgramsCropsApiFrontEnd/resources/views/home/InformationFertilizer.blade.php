@extends('home.TemplateHome')


@section('items')
    {{-- {{ dd($fertilizers) }} --}}
    {{-- {{ dd($crop) }} --}}
    <div class="navbar-nav ms-auto">
        <a href="{{ route('informationCrop', ['id' => $crop['id']]) }}"class="nav-item nav-link">Información</a>
        <a href="{{ route('informationSeeds', ['id' => $crop['id']]) }}" class="nav-item nav-link">Semillas</a>
        <a href="{{ route('informationDiseases', ['id' => $crop['id']]) }}" class="nav-item nav-link">Enfermedades</a>
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
                    <h1 class="text-white mb-3"><span class="fw-light text-dark">Fertilizantes</h1>
                    <p class="text-white mb-4 animated slideInRight">{{ $crop['name'] }}</p>
                </div>
                <div class="mx-auto text-center wow fadeIn  table-responsive" data-wow-delay="0.1s"
                    style="max-height: 30rem">
                    <div class="card">
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Descripición</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- {{ dd($fertilizers) }} --}}
                                    @isset($fertilizers)
                                        @foreach ($fertilizers as $fertilizer)
                                            {{-- {{ dd($fertilizer) }} --}}
                                            <tr>
                                                <td class="text-center">
                                                    @if (isset($fertilizer['image']))
                                                        <img src="{{ $fertilizer['image'] }}" alt="{{ $fertilizer['name'] }}"
                                                            width="300" height="300">
                                                        <br>
                                                        <br>
                                                    @endif
                                                </td>



                                                <td>
                                                    @if (isset($fertilizer['name']))
                                                        <br>
                                                        <strong>Nombre: </strong>{{ $fertilizer['name'] }}<br>
                                                    @endif
                                                    @if (isset($fertilizer['description']))
                                                        <br>
                                                        <strong>Descripción: </strong>{{ $fertilizer['description'] }}<br>
                                                    @endif
                                                    @if (isset($fertilizer['dose']))
                                                        <br>
                                                        <strong>Dosis: </strong>{{ $fertilizer['dose'] }}<br>
                                                    @endif
                                                    @if (isset($fertilizer['price']))
                                                        <br>
                                                        <strong>Precio: </strong>{{ $fertilizer['price'] }}<br>
                                                    @endif
                                                    @if (isset($fertilizer['type']))
                                                        <br>
                                                        <strong>Tipo: </strong>{{ $fertilizer['type'] }}<br>
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
