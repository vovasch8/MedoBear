@extends("layouts.main")

@section("title") {{ $product->name }} @endsection

@section("head")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
    @vite([ 'resources/css/main.css', 'resources/js/main.js', 'resources/js/tables.js'])
@endsection

@section('seo-block')
    <meta name="description" content="{{mb_substr(strip_tags($product->description), 0, 200)}}">
    <meta name="keywords" content="{{$product->keywords}}">
    <meta name="author" content="MedoBear">

    <meta property="og:url" content="{{"https://medo-bear.com/product/" . $product->id}}">
    <meta property="og:type" content="Page">
    <meta property="og:title" content="{{$product->name}}">
    <meta property="og:description" content="{{mb_substr(strip_tags($product->description), 0, 200)}}">
    <meta property="og:image" content="{{ asset('storage') . '/products/' . $product->id . '/' . $product->images[0]->image}}">
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
                            <span class="count mb-1">Кількість:
                                <span data-price="{{ $product->price }}" data-count="{{ $product->count }}" class="text-dark btn btn-sm @if($size === $product->count) btn-warning @else btn-outline-warning @endif me-1 count-value">{{ $product->count }}</span>
                                @if($product->count2)
                                    <span data-price="{{ $product->price2 }}" data-count="{{ $product->count2 }}" class="text-dark btn btn-sm @if($size === $product->count2) btn-warning @else btn-outline-warning @endif me-1 count-value">{{ $product->count2 }}</span>
                                @endif
                                @if($product->count3)
                                    <span data-price="{{ $product->price3 }}" data-count="{{ $product->count3 }}" class="text-dark btn btn-sm @if($size === $product->count3) btn-warning @else btn-outline-warning @endif count-value">{{ $product->count3 }}</span>
                                @endif
                                @if($product->count4)
                                    <span data-price="{{ $product->price4 }}" data-count="{{ $product->count4 }}" class="text-dark btn btn-sm @if($size === $product->count4) btn-warning @else btn-outline-warning @endif count-value">{{ $product->count4 }}</span>
                                @endif
                            </span>
                            <hr>
                            <div class="pt-2 pb-2 btn-block">
                                <span class="fw-bold title-price">Ціна:&nbsp;</span>
                                <span class="fw-bold price text-warning title-price"><span class="product-price" data-count="{{ $size }}">{{ \App\Http\Controllers\CartController::getPriceOfProductSize($product, $size) }}</span> грн</span>
                                <button data-url="{{ route('cart.add_product') }}" class="btn btn-add-product btn-warning text-body-secondary float-end"><i
                                        class="fas fa-shopping-basket"></i> Купити
                                </button>
                            </div>
                            <hr>
                            <h5 class="desc-title text-center mt-3 mb-2 fw-semibold">Опис продукту</h5>
                            <div class="description">{!! $product->description !!}</div>
                            <hr class="mt-2 mb-2">
                            <nav class=" rounded mb-2" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                                {{--                                    <h2 style="margin-top: 2px" class="h6 text-white fw-bold d-block ms-2">Шлях:</h2>--}}
                                <ol class="breadcrumb mb-0 ">
                                    <li class="breadcrumb-item"><a class="link-warning fw-bold" href="{{ route("site.catalog") }}">MedoBear</a></li>
                                    <li class="breadcrumb-item"><a class="link-warning fw-bold" href="{{ route("site.current_catalog", $activeCategory->id) }}">{{ $activeCategory->name }}</a></li>
                                    <li class="breadcrumb-item"><a class="link-warning fw-bold" href="{{ route("site.product", [$product->id, $size]) }}">{{ $product->name }}</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
