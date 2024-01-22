@extends("layouts.main")

@section("title") Корзина @endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-3">
                @include("layouts.aside")
            </div>
            <div class="col-9">
                <div class="row pe-5">
                    <h4 class="fw-bold text-warning cart-title">Корзина</h4>
                   <table class="table">
                       <tr>
                           <th>Назва продукту</th>
                           <th>Вартість</th>
                           <th>Кількість</th>
                           <th>Видалити</th>
                       </tr>
                       @foreach($products as $product)
                           <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}  грн</td>
                                <td>{{$productQuantity[$product->id] }}</td>
                                <td><i onclick="deleteProduct(this)" id="btn-del-{{ $product->id }}" class="fas fa-trash-alt btn-delete"></i></td>
                           </tr>
                           @endforeach
                       <tr>
                           <td>Загальна вартість:</td>
                           <td id="totalPrice" class="fw-bold">{{ $totalPrice  }} грн</td>
                           <td colspan="2"><div class="input-group"><input id="promocodeInput" @if(session()->has('promocode')) disabled value="{{ session('promocode')['name'] }}" @endif type="text" class="form-control promo-input" placeholder="Промокод"><button id="btn-promocode" @if(!session()->has('promocode')) onclick="addPromocode(this)" @endif class="btn btn-warning"><i class="fas fa-check"></i> Застосувати</button></div><span class="error"></span></td>
                       </tr>
                   </table>
                    <div class="text-center">
                        <button data-bs-toggle="modal" data-bs-target="#orderModal" class="btn btn-warning btn-order"><i class="fas fa-box"></i> Оформити замовлення</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">Оформленя замовлення</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="input-group mb-3">
                        <span class="form-icon">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" class="form-control input-form" placeholder="ПІП">
                    </div>
                    <div class="input-group mb-3">
                        <span class="form-icon">
                            <i class="fas fa-phone"></i>
                        </span>
                        <input type="text" class="form-control input-form" placeholder="Телефон">
                    </div>
                    <div class="input-group mb-3">
                        <span class="form-icon">
                            <i class="fas fa-city"></i>
                        </span>
                        <select name="city" class="form-select">
                            <option value="1">Kiev</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-order"><i class="fas fa-shipping-fast"></i> Оформити</button>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteProduct(el) {
        let idProduct = $(el).attr('id');
        idProduct = idProduct.substr(8);

        $.ajax({
            type:'POST',
            url:"{{ route('deleteProduct') }}",
            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id_product" : idProduct},
            success: function (response) {
                let data = jQuery.parseJSON(response);
                $("#productCounter").text(data.count);
                $(el).closest("tr").remove();
                $("#totalPrice").text(data.totalPrice + " грн");
            }
        });
    }

    function addPromocode() {
        let promocode = $('#promocodeInput').val();

        if (promocode.length) {
            $.ajax({
                type: 'POST',
                url: "{{ route('addPromocode') }}",
                data: {"_token": $('meta[name="csrf-token"]').attr('content'), "promocode": promocode},
                success: function (response) {
                    if (typeof response['error'] !== "undefined") {
                        $(".error").text(response['error']);
                        $("#promocodeInput").css('border-color', 'red');
                    } else {
                        $("#totalPrice").text(response + " грн");
                        $("#promocodeInput").attr('disabled', 'disabled');
                        $("#promocodeInput").css('border-color', 'lightgrey');
                        $("#btn-promocode").attr("onclick", "");
                        $(".error").text("");
                    }
                }
            });
        }
    }
</script>
