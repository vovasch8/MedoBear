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
                    <h5 class="modal-title fw-bold" id="exampleModalLabel"><i class="fas fa-box form-icon"></i> Оформленя замовлення</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="input-group mb-3">
                        <span class="form-icon">
                            <i class="fas fa-user"></i>
                        </span>
                            <input type="text" class="form-control input-form" name="pip" placeholder="ПІП" required>
                        </div>
                        <div class="input-group mb-3">
                        <span class="form-icon">
                            <i class="fas fa-phone"></i>
                        </span>
                            <input type="phone" class="form-control input-form" name="phone" placeholder="Телефон" required>
                        </div>
                        <div class="poshta-block mb-3 mt-1 d-flex justify-content-center border-bottom pb-2">
                            <input type="radio" class="btn-check" name="typePoshta" id="novaPoshta" value="novaPoshta" autocomplete="off" checked>
                            <label id="novaPoshtaLabel" class="btn d-flex" for="novaPoshta"><img width="30px" height="30px" src="{{ asset("storage") . "/icons/nova.png" }}" alt="nova poshta">&nbsp; Нова пошта</label>

                            <input type="radio" class="btn-check" name="typePoshta" id="ukrPoshta" value="ukrPoshta" autocomplete="off">
                            <label id="ukrPoshtaLabel" class="btn d-flex" for="ukrPoshta"><img width="20px" height="22px" src="{{ asset("storage") . "/icons/ukr.png" }}" alt="nova poshta">&nbsp; Укр пошта</label>
                        </div>
                        <div class="nova-poshta-block">
                            <div class="nova-poshta-type-delivery d-flex justify-content-center mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input novaRadios" type="radio" name="novaOptions" id="novaWarehouse" value="warehouse" checked>
                                    <label class="form-check-label" for="novaWarehouse">У відділення/поштомат</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input novaRadios" type="radio" name="novaOptions" id="novaCourier" value="courier">
                                    <label class="form-check-label" for="novaCourier">Кур'єром</label>
                                </div>
                            </div>
                            <div id="cities" class="input-group mb-3">
                                <span id="cityDrop" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown"
                                      data-bs-auto-close="true" aria-expanded="false"><i class="fas fa-city search-icon"></i></span>
                                <input autocomplete="off" oncontextmenu="return false;" data-url="{{ route("getCities") }}" id="searchCities" type="search"
                                       class="form-control search-input" placeholder="Населений пункт" required>
                                <ul class="cities-select dropdown-menu search-block">
                                    <li><a class="dropdown-item disabled" href="#">Введіть населений пункт!</a></li>
                                </ul>
                            </div>
                            <div id="warehouses" class="input-group mb-3">
                                <span id="warehousesDrop" class="btn btn-warning dropdown-toggle"
                                      data-bs-toggle="dropdown"
                                      data-bs-auto-close="true" aria-expanded="false"><i class="fas fa-warehouse search-icon"></i></span>
                                <input autocomplete="off" oncontextmenu="return false;" data-url="{{ route("getWarehouses") }}" id="searchWarehouses" type="search"
                                       class="form-control search-input" placeholder="Введіть № відділення/поштомату або вулицю!" required>
                                <ul class="warehouses-select dropdown-menu search-block">
                                    <li><a class="dropdown-item disabled" href="#">Введіть № відділення/поштомату або вулицю!</a>
                                    </li>
                                </ul>
                            </div>
                            <div id="courier-nova-poshta">
                                <div class="input-group mb-3">
                                <span id="cityCourierDrop" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown"
                                      data-bs-auto-close="true" aria-expanded="false"><i class="fas fa-city search-icon"></i></span>
                                    <input autocomplete="off" oncontextmenu="return false;" data-url="{{ route("getCities") }}" id="searchCourierCities" type="search"
                                           class="form-control search-input" placeholder="Населений пункт" required>
                                    <ul class="cities-courier-select dropdown-menu search-block">
                                        <li><a class="dropdown-item disabled" href="#">Введіть населений пункт!</a></li>
                                    </ul>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="btn btn-warning form-icon"><i class="fas fa-road"></i></span>
                                    <input type="text" name="nova_street" class="form-control input-form" placeholder="Вулиця" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="btn btn-warning form-icon"><i class="fas fa-building"></i></span>
                                    <input type="text" name="nova_house" class="form-control input-form" placeholder="Будинок" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="btn btn-warning form-icon"><i class="fas fa-window-restore"></i></span>
                                    <input type="text" name="nova_room" class="form-control input-form" placeholder="Квартира">
                                </div>
                            </div>
                        </div>
                        <div class="ukr-poshta-block">
                            <div class="ukr-poshta-type-delivery d-flex justify-content-center mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input ukrRadios" type="radio" name="ukrOptions" id="ukrPostOfiice" value="postOffice" checked>
                                    <label class="form-check-label" for="ukrPostOfiice">У відділення </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input ukrRadios" type="radio" name="ukrOptions" id="ukrCourier" value="courier">
                                    <label class="form-check-label" for="ukrCourier">Кур'єром</label>
                                </div>
                            </div>
                            <div id="ukrCities" class="input-group mb-3">
                                <span id="ukrPoshtaCityDrop" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown"
                                      data-bs-auto-close="true" aria-expanded="false"><i class="fas fa-city search-icon"></i></span>
                                <input autocomplete="off" oncontextmenu="return false;" data-url="{{ route("getUkrPoshtaCities") }}" id="searchUkrPoshtaCities" type="search"
                                       class="form-control search-input" placeholder="Населений пункт" required>
                                <ul class="ukr-poshta-cities-select dropdown-menu search-block">
                                    <li><a class="dropdown-item disabled" href="#">Введіть населений пункт!</a></li>
                                </ul>
                            </div>
                            <div id="postOffices" class="input-group mb-3">
                                <span id="postOfficesDrop" class="btn btn-warning dropdown-toggle"
                                      data-bs-toggle="dropdown"
                                      data-bs-auto-close="true" aria-expanded="false"><i class="fas fa-warehouse search-icon"></i></span>
                                <input autocomplete="off" oncontextmenu="return false;" data-url="{{ route("getPostOffices") }}" id="searchPostOffices" type="search"
                                       class="form-control search-input" placeholder="Індекс" required>
                                <ul class="post-offices-select dropdown-menu search-block">
                                    <li><a class="dropdown-item disabled" href="#">Введіть індекс відділення!</a>
                                    </li>
                                </ul>
                            </div>
                            <div id="courier-ukr-poshta">
                                <div class="input-group mb-3">
                                     <span id="ukrPoshtaCourierCityDrop" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown"
                                      data-bs-auto-close="true" aria-expanded="false"><i class="fas fa-city search-icon"></i></span>
                                    <input autocomplete="off" oncontextmenu="return false;" data-url="{{ route("getUkrPoshtaCities") }}" id="searchUkrPoshtaCourierCities" type="search"
                                           class="form-control search-input" placeholder="Населений пункт" required>
                                    <ul class="ukr-poshta-courier-cities-select dropdown-menu search-block">
                                        <li><a class="dropdown-item disabled" href="#">Введіть населений пункт!</a></li>
                                    </ul>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="btn btn-warning form-icon"><i class="fas fa-road"></i></span>
                                    <input type="text" class="form-control input-form" name="ukr_street" placeholder="Вулиця" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="btn btn-warning form-icon"><i class="fas fa-building"></i></span>
                                    <input type="text" class="form-control input-form" name="ukr_house" placeholder="Будинок" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="btn btn-warning form-icon"><i class="fas fa-window-restore"></i></span>
                                    <input type="text" class="form-control input-form" name="ukr_room" placeholder="Квартира">
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="d-block w-100" id="error-block"></span>
                </div>
                <div class="modal-footer">
                    <button id="btn-order" data-url="{{ route("createOrder") }}" type="button" class="btn btn-warning btn-order"><i class="fas fa-shipping-fast"></i> Оформити</button>
                </div>
            </div>
        </div>
    </div>

@endsection


