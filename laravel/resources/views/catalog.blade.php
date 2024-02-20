@extends("layouts.main")

@section("title") Каталог @endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-3">
                @include("layouts.aside")
            </div>
            <div class="col-9">
                <div class="row pe-5">
                    @foreach($products as $product)
                        <div class="col-4 mb-4">
                            <a href="{{ route('product', $product->id)  }}" id="p-{{$product->id}}" class="card shadow-sm product">
                                <img width="100%" height="225px" class="bd-placeholder-img card-img-top"
                                     src="{{ asset("storage") . "/products/" . $product->id . "/" . (isset($product->images[0]) ? $product->images[0] : '')}}" alt="MedoBear">
                                <div class="card-body">
                                    <h5 class="card-text fw-semibold">{{ $product->name }}</h5>
                                    <span class="count">Кількість: {{ $product->count }}</span>
                                    <div class="d-flex justify-content-between align-items-center btn-block">
                                        <span class="fw-bold price text-warning">{{$product->price}} грн</span>
                                        <button data-url="{{ route('addProduct') }}" class="btn-add-product btn btn-warning text-body-secondary"><i
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

