@extends("layouts.main")

@section("title") {{ $product->name }} @endsection

@section("head")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-3">
                @include("layouts.aside")
            </div>
            <div class="col-9">
                <div class="row pe-5">
                    <div class="col-6">
                        <div class="row">
                            <div class="main-color p-2 border border-success rounded">
                                <h5 class="text-center text-light fw-bold mb-2">{{ $product->name }}</h5>
                                <div id="fotorama" class="fotorama bg-light" data-width="100%" data-ratio="800/600"
                                     data-allowfullscreen="true"  data-loop="true">
                                    @foreach($product->images as $image)
                                        <img
                                            src="{{asset("storage") . "/products/" . $product->id . "/" . (isset($image) ? $image : '')}}"/>
                                    @endforeach
                                    {{--                                            @foreach($album['videos'] as $video)--}}
                                    {{--                                                <a href="{{asset('storage') . '/albums/' . $video}}" data-video="true">--}}
                                    {{--                                                    <img src="{{asset('storage') . '/albums/video.jpg'}}" alt="">--}}
                                    {{--                                                </a>--}}
                                    {{--                                            @endforeach--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div id="p-{{ $product->id }}" class="card p-3 mb-1">
                            <h5 class="card-text fw-semibold">{{ $product->name }}</h5>
                            <span class="count">Кількість: {{ $product->count }}</span>
                            <br>
                            <span class="fw-bold">Опис</span>
                            <p>{{ $product->description }}</p>
                            <div class="p-1">
                                <span class="fw-bold">Ціна:&nbsp;</span>
                                <span class="fw-bold price text-warning">{{$product->price}} грн</span>
                                <button data-url="{{ route('addProduct') }}" class="btn btn-add-product btn-warning text-body-secondary float-end"><i
                                        class="fas fa-shopping-basket"></i> Купити
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
