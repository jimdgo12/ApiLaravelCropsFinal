@extends('home.TemplateHome')

@section('items')
    <div class="navbar-nav ms-auto">
        {{-- {{ dd($crop) }} --}}
        <a href="{{ route('informationCrop', ['id' => $crop['id']])}}" class="nav-item nav-link">Información</a>
        <a href="{{ route('informationSeeds', ['id' => $crop['id']]) }}" class="nav-item nav-link">Semillas</a>
        <a href="{{ route('informationDiseases', $crop['id']) }}" class="nav-item nav-link">Enfermedades</a>
        <a href="{{ route('informationFertilizers', $crop['id']) }}" class="nav-item nav-link">Fertilizantes</a>
    </div>
@endsection

@section('title')
    {{ $crop['name']}}
@endsection<a href="{{ route('informationSeeds', ['id' => $crop['id']]) }}" class="nav-item nav-link"></a>

@section('image')
    <img class="img-fluid animated pulse infinite" src="{{ $crop['image']}}" alt="">
@endsection

@section('content')
    <section class="page-section bg-primary" id="semillas">
        <div class="container-fluid how-to-use bg-primary my-5 py-5">
            <div class="container text-white py-5">
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h3 class="text-black mb-2"><span class="mx-auto text-center wow fadeIn">Nombre</h3>
                    <p class="text-white mb-5 animated slideInRight">{{ $crop['name'] ?? '' }}</p>
                </div>
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h3 class="text-black mb-2"><span class="mx-auto text-center wow fadeIn">Nombre científico</h3>
                    <p class="text-white mb-5 animated slideInRight">{{ $crop['nameScientific'] ?? '' }}</p>
                </div>
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h3 class="text-black mb-2"><span class="mx-auto text-center wow fadeIn">Descripción</h3>
                    <p class="text-white mb-5 animated slideInRight">{{ $crop['description'] ?? '' }}</p>
                </div>
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h3 class="text-black mb-2"><span class="mx-auto text-center wow fadeIn">Historia</h3>
                    <p class="text-white mb-5 animated slideInRight">{{ $crop['history'] ?? '' }}</p>
                </div>
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h3 class="text-black mb-2"><span class="mx-auto text-center wow fadeIn">Fases de fertilización</h3>
                    <p class="text-white mb-4 animated slideInRight">{{ $crop['phaseFertilizer'] ?? '' }}</p>
                </div>
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h3 class="text-black mb-2"><span class="mx-auto text-center wow fadeIn">Fases de cosecha</h3>
                    <p class="text-white mb-4 animated slideInRight">{{ $crop['phaseHarvest'] ?? '' }}</p>
                </div>
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h3 class="text-black mb-2"><span class="mx-auto text-center wow fadeIn">Extensión</h3>
                    <p class="text-white mb-4 animated slideInRight">{{ $crop['spreading'] ?? '' }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
