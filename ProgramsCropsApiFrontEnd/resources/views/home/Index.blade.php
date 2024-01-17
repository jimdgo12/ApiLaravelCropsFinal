@extends('home.TemplateHome')

@section('items')
    <div class="navbar-nav ms-auto">
        <a href="#crop" class="nav-item nav-link active">Cultivos</a>
    </div>
@endsection

@section('title')
    Cultivos <br>para la vida
@endsection

@section('image')
    <img class="img-fluid animated pulse infinite" src="{{ asset('home/img/frutas2.jpg') }}" alt="">
@endsection

@section('content')
    <section class="page-section bg-primary" id="crop">

        <div class="container-fluid how-to-use bg-primary my-5 py-5">
            <div class="container text-white py-5">
                <div class="mx-auto text-center wow fadeIn  " data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="text-white mb-3"><span class="fw-light text-dark">Cultivos para la vida</h1>
                </div>
                <div class="row gx-4 gx-lg-5">
                    <div class="offset-2 col-lg-8 text-center table-responsive" style="max-height: 30rem">
                        @foreach ($crops as $crop)
                        <a href="{{ route('informationCrop', ['id' => $crop['id']]) }}">
                                <div class="card mb-3" style="max-width: 900px;">
                                    <div class="row g-0 d-flex align-content-center">
                                        <div class="col-md-4">
                                            <img src="{{ $crop['image'] }}" class="img-fluid" alt="Card title">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $crop['name'] }}</h5>
                                                <p class="card-text ">{{ $crop['description'] }}</p>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
    </section>
@endsection
<!-- Feature Start -->
