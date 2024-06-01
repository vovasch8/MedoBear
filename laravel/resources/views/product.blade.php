@extends("layouts.main")

@section("title") {{ $product->name }} @endsection

@section("head")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
@endsection

@section("content")
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-lg-3 product-entity-sidebar">
                @include("layouts.aside")
            </div>
            <div class="col-md-8 col-lg-9 col-sm-12">
                <div class="row product-entity-row pe-5">
                    <div class="col-lg-6 col-md-12">
                        <div class="row mb-3">
                            <div class="main-color p-2 border border-success rounded">
                                <h1 class="text-center text-light fw-semibold name-product mb-1">{{ $product->name }}</h1>
                                <div id="fotorama" class="fotorama bg-dark" data-width="100%" data-ratio="800/600"
                                     data-allowfullscreen="true" data-nav="thumbs" data-loop="true">
                                    @foreach($product->images as $image)
                                        <img
                                            src="{{asset("storage") . "/products/" . $product->id . "/" . (isset($image) ? $image->image : '')}}"/>
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
                    <div class="col-lg-6 col-md-12">
                        <div id="p-{{ $product->id }}" class="card p-3 mb-3">
                            <a href="{{ URL::previous() }}" class="btn-back btn btn-warning text-body-secondary"><i class="fas fa-angle-left"></i>&nbsp;Назад</a>
                            <h1 class="card-text fw-semibold name-product">{{ $product->name }}</h1>
                            <span class="count mb-1">Кількість: {{ $product->count }}</span>
                            <hr>
                            <div class="pt-2 pb-2">
                                <span class="fw-bold title-price">Ціна:&nbsp;</span>
                                <span class="fw-bold price text-warning title-price">{{$product->price}} грн</span>
                                <button data-url="{{ route('cart.add_product') }}" class="btn btn-add-product btn-warning text-body-secondary float-end"><i
                                        class="fas fa-shopping-basket"></i> Купити
                                </button>
                            </div>
                            <hr>
                            <h5 class="desc-title text-center mt-3 mb-2 fw-semibold">Опис продукту</h5>
                            <div class="description">{!! $product->description !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
