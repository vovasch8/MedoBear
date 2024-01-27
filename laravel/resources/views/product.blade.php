@extends("layouts.main")

@section("title") {{ $product->name }} @endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-3">
                @include("layouts.aside")
            </div>
            <div class="col-9">
                <div class="row pe-5">
                    <div class="col-6">
                        <img width="100%" height="225px" class="bd-placeholder-img card-img-top product-img"
                             src="{{$product->image}}" alt="MedoBear">
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
