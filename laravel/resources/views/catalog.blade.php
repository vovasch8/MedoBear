@extends("layouts.main")

@section("title") {{ $activeCategory->name }} @endsection

@section("head")
    @vite([ 'resources/css/main.css', 'resources/js/main.js', 'resources/js/price-filter.js', 'resources/js/slider.js', 'resources/css/price-filter.css', 'resources/css/slider.css'])
@endsection

@section('seo-block')
    <meta name="description" content="Інтернет магазин медових товарів MedoBear: натуральний мед, пилок, віск та інші продукти бджільництва. Висока якість, швидка доставка, вигідні ціни. У нас в наявності багато бджолопродуктів, які підійдуть вам по смаку!">
    <meta name="keywords" content="@if(Route::currentRouteName() == "site.catalog"){{ '1, 2, 3'}}@else{{ $activeCategory->keywords }}@endif">
    <meta name="author" content="MedoBear">

    <meta property="og:url" content="https://medo-bear.com">
    <meta property="og:type" content="Page">
    <meta property="og:title" content="Інтернет Магазин - MedoBear">
    <meta property="og:description" content="Інтернет магазин медових товарів MedoBear: натуральний мед, пилок, віск та інші продукти бджільництва. Висока якість, швидка доставка, вигідні ціни. У нас в наявності багато бджолопродуктів, які підійдуть вам по смаку!">
    <meta property="og:image" content="{{ asset('logo.png') }}">
@endsection

@section("content")
    <div class="container-fluid category" data-category="{{ $activeCategory->id }}" data-category-name="{{ $activeCategory->name }}">
        <div class="row">
            <button style="background: #2d3748;color: #ffc106;font-weight: bold;" class="btn-menu btn"><i
                    class="fas fa-bars"></i></button>
            <div class="col-md-4 col-lg-3 col-sm-5 sidebar">
                @include("layouts.aside")
            </div>
            <div class="col-md-8 col-lg-9 col-sm-7 product-content">
                <div class="row pe-5 row-panel">
                    <div class="d-flex flex-md-column flex-sm-column flex-column flex-lg-row mb-3 filter-url" data-url="{{ route('site.filters') }}">
                        <div class="sort d-flex col-lg-3 col-xl-2 col-md-6 offset-md-3 offset-lg-0 mb-md-2 col-sm-8 offset-sm-2 mb-sm-2 col-xs-6 offset-3 mb-xs-2" data-sort="order">
                            <span class="fw-bold text-muted mt-1">Сортування:&nbsp;</span>
                            <i class="fas fa-sort-alpha-down me-1"></i>
                            <i class="fas fa-sort-numeric-down me-1"></i>
                        </div>
                        <div class="col-lg-4 col-xl-5 col-md-8 offset-md-2 offset-lg-0 mb-md-2 col-sm-12 mb-sm-2 order-md-2 order-lg-1 col-xs-12 order-2">
                            <div class="d-flex">
                                <div class="vr me-2"></div>
                                <div class="input-group">
                                    <input type="search" class="form-control me-1 search-field" placeholder="Пошук">
                                    <button class="btn btn-warning btn-search d-flex search-btn"><i class="fas fa-search"></i>&nbsp;<span>Знайти</span>
                                    </button>
                                </div>
                                <div class="vr ms-2"></div>
                            </div>
                        </div>
                        <div class="col-lg-5 d-flex col-md-8 offset-md-2 offset-lg-0 col-sm-12 offset-sm-0 order-md-1 order-lg-2 offset-1 col-11 mb-xs-2 order-1">
                            <span class="fw-bold text-muted mt-1 ms-2 span-price">Ціна:&nbsp;</span>
                            <main id="app" class="mt-0">
                                <div id="slider"></div>
                            </main>
                        </div>
                    </div>
                    <hr class="mb-2">
                    <div class="text-center d-flex justify-content-center">
                        <span class="d-block">
                            <span class="ps-5 pe-5 d-block"><h1 class="text-muted mt-0 h3 h-value">{{ $activeCategory->name }}</h1></span>
                            <hr class="mt-0 mb-4 text-warning border-3">
                        </span>
                    </div>
                </div>

                <div class="main-row pe-5 container-empty text-center" @if($products->isEmpty()) style="display: block;" @else style="display: none;" @endif>
                    <img class="empty-products" src="{{ asset('icons') . "/empty.png" }}" alt="Пусто"><br>
                </div>
                <div class="row pe-5 product-row mb-3 main-row">
                    @foreach($products as $product)
                        <div class="col-12 col-md-8 offset-md-2 offset-lg-0 col-lg-6 col-xl-4 mb-4 product-grid">
                            <a href="{{ route('site.product', [$product->id, $product->count]) }}" id="p-{{$product->id}}"
                               class="card shadow-sm product">
                                <img width="100%" height="225px" class="bd-placeholder-img card-img-top"
                                     src="{{ asset("storage") . "/products/" . $product->id . "/" . (isset($product->images[0]) ? $product->images[0]->image : '')}}"
                                     alt="MedoBear">
                                <div class="card-body">
                                    <h5 class="card-text fw-semibold mb-0 product-name">{{ $product->name }}</h5>
                                    <span class="count">Кількість:
                                        @if($product->count)
                                            <span data-price="{{ $product->price }}" data-count="{{ $product->count }}" class="text-dark btn btn-sm btn-warning me-1 count-value">{{ $product->count }}</span>
                                        @endif
                                        @if($product->count2)
                                            <span data-price="{{ $product->price2 }}" data-count="{{ $product->count2 }}" class="text-dark btn btn-sm btn-outline-warning me-1 count-value">{{ $product->count2 }}</span>
                                        @endif
                                        @if($product->count3)
                                            <span data-price="{{ $product->price3 }}" data-count="{{ $product->count3 }}"class="text-dark btn btn-sm btn-outline-warning count-value">{{ $product->count3 }}</span>
                                        @endif
                                        @if($product->count4)
                                            <span data-price="{{ $product->price4 }}" data-count="{{ $product->count4 }}" class="text-dark btn btn-sm btn-outline-warning count-value">{{ $product->count4 }}</span>
                                        @endif
                                    </span>
                                    <div class="d-flex justify-content-between align-items-center btn-block">

                                        <span class="fw-bold price text-warning"><span class="product-price" data-count="{{ $product->count }}">{{$product->price}}</span> грн</span>
                                        <button data-url="{{ route('cart.add_product') }}"
                                                class="btn-add-product btn btn-warning text-body-secondary"><i
                                                class="fas fa-shopping-basket"></i> Купити
                                        </button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="row pe-5 top-row">
                    <h3 class="text-center text-muted mt-2">ТОП товари</h3>
                    <hr class="mb-4">
                    <!-- Start Header Slider -->
                    <div class="container">
                        <div class="row d-flex">
                            @foreach($mostPopularProducts as $key => $product)
                                    <div id="top-{{ $key }}" class="item mb-4 col-12 col-md-8 offset-md-2 offset-lg-0 col-lg-6 col-xl-4 ps-3 pe-3 pt-3 @if($key == 0) active @endif">
                                        <a href="{{ route('site.product', [$product->id, $product->count]) }}" id="m-{{$product->id}}" class="card shadow-sm product">
                                            <img width="100%" height="225px" class="bd-placeholder-img card-img-top"
                                                             src="{{ asset("storage") . "/products/" . $product->id . "/" . (isset($product->images[0]) ? $product->images[0]->image : '')}}"
                                                             alt="MedoBear">
                                            <div class="card-body">
                                                <h5 class="card-text fw-semibold mb-0">{{ $product->name }}</h5>
                                                <span class="count">Кількість:
                                                        @if($product->count)
                                                            <span data-price="{{ $product->price }}" data-count="{{ $product->count }}" class="text-dark btn btn-sm btn-warning me-1 count-value">{{ $product->count }}</span>
                                                        @endif
                                                        @if($product->count2)
                                                            <span data-price="{{ $product->price2 }}" data-count="{{ $product->count2 }}" class="text-dark btn btn-sm btn-outline-warning me-1 count-value">{{ $product->count2 }}</span>
                                                        @endif
                                                        @if($product->count3)
                                                            <span data-price="{{ $product->price3 }}" data-count="{{ $product->count3 }}" class="text-dark btn btn-sm btn-outline-warning count-value">{{ $product->count3 }}</span>
                                                        @endif
                                                        @if($product->count4)
                                                            <span data-price="{{ $product->price4 }}" data-count="{{ $product->count4 }}" class="text-dark btn btn-sm btn-outline-warning count-value">{{ $product->count4 }}</span>
                                                        @endif
                                                    </span>
                                                <div class="d-flex justify-content-between align-items-center btn-block">
                                                    <span class="fw-bold price text-warning"><span class="product-price" data-count="{{ $product->count }}">{{$product->price}}</span> грн</span>
                                                    <button data-url="{{ route('cart.add_product') }}" class="btn-add-product btn btn-warning text-body-secondary"><i class="fas fa-shopping-basket"></i> Купити</button>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                        </div>
                    </div>
                    <!-- End Header Slider -->
                </div>
            </div>
        </div>
    </div>
@endsection

