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
                        <h5 class="card-text fw-semibold">{{ $product->name }}</h5>
                        <span class="count">Кількість: {{ $product->count }}</span>
                        <br>
                        <br>
                        <span class="fw-bold">Опис</span>
                        <p>{{ $product->description }}</p>
                        <div class="justify-content-between align-items-center btn-block">
                            <span class="fw-bold">Ціна: </span><span class="fw-bold price text-warning">{{$product->price}} грн</span>
                            <br>
                            <br>
                            <button id="btn-cart" class="btn btn-warning text-body-secondary"><i
                                    class="fas fa-shopping-basket"></i> Купити
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
