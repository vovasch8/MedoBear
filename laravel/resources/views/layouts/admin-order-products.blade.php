@foreach($products as $key => $product)
    <div id='p-{{$key}}' data-url="{{ route('order.update_order') }}" data-id="{{$product->id}}" data-order-id="{{$product->order_id}}" data-count-substance="{{$product->count_substance}}" style='height: 120px; background: cornsilk!important;' class='card d-block mb-3 cart-order'>
        <img class='float-start d-block me-2 img-product-order' width='150px' height='120px' src=' {{ asset('storage') . "/products/" . $product->id . "/" . $product->images[0]->image}}'>
        <div class='d-block'>
            <div class="d-flex justify-content-between">
                <a href='{{ route("site.product", [$product->id, $product->count_substance]) }}' class='mt-1 fw-bold text-decoration-none text-dark d-block'>{{$product->name . " " . $product->count_substance}}</a>
                <i onclick="removeProduct(this)" data-key="{{$key}}" data-id="{{$product->id}}" data-order-id="{{$product->order_id}}" data-count-substance="{{$product->count_substance}}" data-url="{{ route("admin_orders.remove_product_from_order") }}" class="fa-solid fa-trash me-2 mt-2"></i>
            </div>
            <hr class="mt-2 mb-1">
            <span class="d-flex justify-content-between count-products"><span class='d-block fw-bold d-flex'><span class='text-warning'>Кількість:&nbsp;</span> <span class="count-number">{{$product->count}}</span> шт.<div class="d-flex"></div></span><span><button class="btn btn-sm btn-warning counter me-1 plus">+</button><button class="btn btn-sm btn-warning counter me-2 minus">-</button></span></span>
            <span class='d-block fw-bold'><span class='text-warning'>Ціна:&nbsp;</span><span class="count-price">{{$product->price}}</span>&nbsp;грн.</span>
        </div>
    </div>
@endforeach

<script>
    $('.plus').click(function () {
        let counter = $(this).closest('.count-products').find('.count-number').text();
        let url = $(this).closest('.cart-order').attr("data-url");
        let id_product = $(this).closest('.cart-order').attr("data-id");
        let id_order = $(this).closest('.cart-order').attr("data-order-id");
        let size = $(this).closest('.cart-order').attr("data-count-substance");

        counter++;
        $(this).closest('.count-products').find('.count-number').text(counter);
        $.ajax({
            type: 'POST',
            url: url,
            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id_product": id_product, "id_order": id_order, "size": size, "count": counter},
            success: function (response) {
                $('table tr td:first').each(function(index, element) {
                    alert(element.text());
                });
            }
        });
    });

    $('.minus').click(function () {
        let counter = $(this).closest('.count-products').find('.count-number').text();
        if (counter != 1) {
            counter--;
            $(this).closest('.count-products').find('.count-number').text(counter);
        }
        let url = $(this).closest('.cart-order').attr("data-url");
        let id_product = $(this).closest('.cart-order').attr("data-id");
        let id_order = $(this).closest('.cart-order').attr("data-order-id");
        let size = $(this).closest('.cart-order').attr("data-count-substance");

        $(this).closest('.count-products').find('.count-number').text(counter);
        $.ajax({
            type: 'POST',
            url: url,
            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id_product": id_product, "id_order": id_order, "size": size, "count": counter},
            success: function (response) {

            }
        });
    });

    function removeProduct(el) {
        let id = $(el).attr('data-id');
        let order_id = $(el).attr('data-order-id');
        let count = $(el).attr('data-count-substance');
        let key = $(el).attr('data-key');
        let url = $(el).attr("data-url");
        $.confirm({
            title: 'Підтвердження',
            content: 'Ви впевнені що хочете видалити цей запис?',
            buttons: {
                confirm: {
                    text: 'Так',
                    btnClass: 'btn-dark',
                    action: function () {
                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id_product": id, "id_order": order_id, "count_substance": count},
                            success: function (response) {
                                $('#p-' + key).remove();
                            }
                        });
                    }
                },
                cancel: {
                    text: 'Закрити',
                    btnClass: 'btn-dark',
                    action: function () {

                    }
                }
            }
        });
    }
</script>
