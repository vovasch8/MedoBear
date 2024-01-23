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
                                <td><i id="btn-del-{{ $product->id }}" class="fas fa-trash-alt btn-delete" data-url="{{route("deleteProduct")}}"></i></td>
                           </tr>
                           @endforeach
                       <tr>
                           <td>Загальна вартість:</td>
                           <td id="totalPrice" class="fw-bold">{{ $totalPrice  }} грн</td>
                           <td colspan="2"><div class="input-group"><input id="promocodeInput" @if(session()->has('promocode')) disabled value="{{ session('promocode')['name'] }}" @endif type="text" class="form-control promo-input" placeholder="Промокод"><button data-url="{{ route("addPromocode") }}" id="btn-promocode" @if(!session()->has('promocode')) @endif class="btn btn-warning"><i class="fas fa-check"></i> Застосувати</button></div><span class="error"></span></td>
                       </tr>
                   </table>
                    <div class="text-center">
                        <button data-bs-toggle="modal" data-bs-target="#orderModal" class="btn btn-warning btn-order"><i class="fas fa-box"></i> Оформити замовлення</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        <div class="poshta-block mb-3 mt-1 text-center">
                            <input type="radio" class="btn-check" name="options-base" id="option5" autocomplete="off" checked>
                            <label class="btn" for="option5"><i class="fas fa-store"></i> Нова пошта</label>

                            <input type="radio" class="btn-check" name="options-base" id="option6" autocomplete="off">
                            <label class="btn" for="option6"><i class="fas fa-store-alt"></i> Укр пошта</label>
                            <hr class="mt-1">
                        </div>

                        <div class="input-group mb-3">
                            <span class="form-icon"><i class="fas fa-city"></i></span>
                            <input data-url="{{ route("getCities") }}" id="searchCities" type="search"
                                   class="form-control" placeholder="Населений пункт">
                            <button id="cityDrop" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown"
                                    data-bs-auto-close="true" aria-expanded="false"></button>
                            <ul class="cities-select dropdown-menu">
                                <li><a class="dropdown-item disabled" href="#">Введіть населений пункт!</a></li>
                            </ul>
                        </div>
                        <div id="warehouses" class="input-group mb-3">
                            <span class="form-icon"><i class="fas fa-warehouse"></i></span>
                            <input data-url="{{ route("getWarehouses") }}" id="searchWarehouses" type="search"
                                   class="form-control" placeholder="Відділення чи вулиця">
                            <button id="warehousesDrop" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown"
                                    data-bs-auto-close="true" aria-expanded="false"></button>
                            <ul class="warehouses-select dropdown-menu">
                                <li><a class="dropdown-item disabled" href="#">Введіть відділення чи вулицю!</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-order"><i class="fas fa-shipping-fast"></i> Оформити</button>
                </div>
            </div>
        </div>
    </div>

@endsection


