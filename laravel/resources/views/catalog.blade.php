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
                        <div class="col-4">
                            <a href="{{ route('product', $product->id)  }}" id="p-{{$product->id}}" class="card shadow-sm product">
                                <img width="100%" height="225px" class="bd-placeholder-img card-img-top"
                                     src="{{$product->image}}" alt="MedoBear">
                                <div class="card-body">
                                    <h5 class="card-text fw-semibold">{{ $product->name }}</h5>
                                    <span class="count">Кількість: {{ $product->count }}</span>
                                    <div class="d-flex justify-content-between align-items-center btn-block">
                                        <span class="fw-bold price text-warning">{{$product->price}} грн</span>
                                        <button onclick="event.preventDefault(); addProduct(this);" class="btn btn-cart btn-warning text-body-secondary"><i
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

<script>
    function addProduct (el){
        let idProduct = $(el).closest('.card').attr('id');
        idProduct = idProduct.substr(2);

        $.ajax({
            type:'POST',
            url:"{{ route('addProduct') }}",
            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id_product" : idProduct},
            success: function (response) {
                $("#productCounter").css("display", "inline-block")
                $("#productCounter").text(response);
            }
        });
    }
</script>
