@foreach($products as $product)
    <div class="col-12 col-md-12 col-lg-6 col-xl-4 mb-4 product-grid">
        <a onclick="if (event.target.classList.contains('note-add-product')){ event.preventDefault() }" href="{{ route('site.product', [$product->id, $product->startCount]) }}" id="p-{{$product->id}}"
           class="card shadow-sm product">
            <img width="100%" height="225px" class="bd-placeholder-img card-img-top"
                 src="{{ asset("storage") . "/products/" . $product->id . "/" . (isset($product->images[0]) ? $product->images[0]->image : '')}}"
                 alt="MedoBear">
            <div class="card-body">
                <h5 class="card-text fw-semibold mb-0 product-name">{{ $product->name }}</h5>
                <span class="count">Кількість:
                    @if($product->count)
                        <span data-price="{{ $product->price }}" data-count="{{ $product->count }}" class="text-dark btn btn-sm btn-warning me-1 count-value-load note-add-product">{{ $product->count }}</span>
                    @endif
                    @if($product->count2)
                        <span data-price="{{ $product->price2 }}" data-count="{{ $product->count2 }}" class="text-dark btn btn-sm btn-outline-warning me-1 count-value-load note-add-product">{{ $product->count2 }}</span>
                    @endif
                    @if($product->count3)
                        <span data-price="{{ $product->price3 }}" data-count="{{ $product->count3 }}" class="text-dark btn btn-sm btn-outline-warning count-value-load note-add-product">{{ $product->count3 }}</span>
                    @endif
                    @if($product->count4)
                        <span data-price="{{ $product->price4 }}" data-count="{{ $product->count4 }}" class="text-dark btn btn-sm btn-outline-warning count-value-load note-add-product">{{ $product->count4 }}</span>
                    @endif
                </span>
                <div class="d-flex justify-content-between align-items-center btn-block">
                    <span class="fw-bold price text-warning"><span class="product-price" data-count="{{ $product->startCount }}">{{ $product->startPrice }}</span> грн</span>
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
        let count = $(el).closest('.btn-block').find('.product-price').attr('data-count');
        idProduct = idProduct.substr(2);

        $.ajax({
            type:'POST',
            url: url,
            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id_product" : idProduct, "count_value": count},
            success: function (response) {
                $("#productCounter").css("display", "inline-block")
                $("#productCounter").text(response);
            }
        });
    }
    $('.count-value-load').click(function (event) {
        event.preventDefault();
        let price = $(this).attr('data-price');
        let oldActiveEl = $(this).parent().find('.btn-warning');
        oldActiveEl.removeClass('btn-warning');
        oldActiveEl.addClass('btn-outline-warning');
        $(this).removeClass('btn-outline-warning');
        $(this).addClass('btn-warning');
        $(this).parent().parent().find('.product-price').text(price);
        $(this).parent().parent().find('.product-price').attr("data-count", $(this).attr("data-count"));
        let url = $(this).closest('.product').attr("href");
        let pos = url.lastIndexOf('/');
        url = url.substring(0, pos) + '/' + $(this).attr("data-count");
        $(this).closest('.product').attr("href", url);
    });
</script>
@endif
