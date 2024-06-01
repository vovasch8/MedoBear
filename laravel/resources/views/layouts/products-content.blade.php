@foreach($products as $product)
    <div class="col-12 col-md-12 col-lg-6 col-xl-4 mb-4 product-grid">
        <a onclick="if (event.target.classList.contains('note-add-product')){ event.preventDefault() }" href="{{ route('site.product', $product->id) }}" id="p-{{$product->id}}"
           class="card shadow-sm product">
            <img width="100%" height="225px" class="bd-placeholder-img card-img-top"
                 src="{{ asset("storage") . "/products/" . $product->id . "/" . (isset($product->images[0]) ? $product->images[0]->image : '')}}"
                 alt="MedoBear">
            <div class="card-body">
                <h5 class="card-text fw-semibold mb-0 product-name">{{ $product->name }}</h5>
                <span class="count">Кількість: {{ $product->count }}</span>
                <div class="d-flex justify-content-between align-items-center btn-block">
                    <span class="fw-bold price text-warning"><span class="product-price">{{$product->price}}</span> грн</span>
                    <button onclick="addToCart(this);" data-url="{{ route('cart.add_product') }}"
                            class="note-add-product btn btn-warning text-body-secondary"><i
                            class="note-add-product fas fa-shopping-basket"></i> Купити
                    </button>
                </div>
            </div>
        </a>
    </div>
@endforeach

@if(!$products->isEmpty())
<script>
    function addToCart(el) {
        let url = $(el).attr("data-url");
        let idProduct = $(el).closest('.card').attr('id');
        idProduct = idProduct.substr(2);

        $.ajax({
            type:'POST',
            url: url,
            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id_product" : idProduct},
            success: function (response) {
                $("#productCounter").css("display", "inline-block")
                $("#productCounter").text(response);
            }
        });
    }
</script>
@endif
