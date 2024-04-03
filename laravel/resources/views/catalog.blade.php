@extends("layouts.main")

@section("title") Каталог @endsection

@section("content")
    <div class="container-fluid">
        <div class="row">
            <button style="background: #2d3748;color: #ffc106;font-weight: bold;" class="btn-menu btn"><i class="fas fa-bars"></i></button>
            <div class="col-md-4 col-lg-3 col-sm-5 sidebar">
                @include("layouts.aside")
            </div>
            <div class="col-md-8 col-lg-9 col-sm-7 product-content">
                <div class="row pe-5 product-row">
                    @foreach($products as $product)
                        <div class="col-12 col-md-12 col-lg-6 col-xl-4 mb-4">
                            <a href="{{ route('site.product', $product->id) }}" id="p-{{$product->id}}" class="card shadow-sm product">
                                <img width="100%" height="225px" class="bd-placeholder-img card-img-top"
                                     src="{{ asset("storage") . "/products/" . $product->id . "/" . (isset($product->images[0]) ? $product->images[0]->image : '')}}" alt="MedoBear">
                                <div class="card-body">
                                    <h5 class="card-text fw-semibold mb-0">{{ $product->name }}</h5>
                                    <span class="count">Кількість: {{ $product->count }}</span>
                                    <div class="d-flex justify-content-between align-items-center btn-block">
                                        <span class="fw-bold price text-warning">{{$product->price}} грн</span>
                                        <button data-url="{{ route('cart.add_product') }}" class="btn-add-product btn btn-warning text-body-secondary"><i
                                                class="fas fa-shopping-basket"></i> Купити
                                        </button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

