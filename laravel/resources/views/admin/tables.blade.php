@extends("layouts.admin")

@section("head")
    @vite(['resources/css/styles.css', 'resources/js/scripts.js', 'resources/js/datatables-simple.js', 'resources/js/tables.js'])
@endsection

@section("content")
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Таблиці</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.blade.php">Панель</a></li>
                <li class="breadcrumb-item active">Дані</li>
            </ol>
            <div class="card mb-4">
            </div>
            <div class="card mb-4">
                <div class="card-header d-flex">
                    <i class="fas fa-table me-1" style="font-size: xx-large"></i>
                    <select class="form-select w-25 float-end" name="typeData" id="typeDat">
                        <option selected value="Замовлення">Замовлення</option>
                        <option value="Категорії">Категорії</option>
                        <option value="Продукти">Продукти</option>
                        <option value="Повідомлення">Повідомлення</option>
                        <option value="Користувачі">Користувачі</option>
                    </select>
                </div>
                <div class="card-body">
                    <div class="edit-block">
                        <div id="edit-form" class="input-group">
                            <span id="old-text"></span>
                            <input id="edit-input" type="text" class="form-control w-75" placeholder="Редагування">
                            <button id="edit-btn" class="btn btn-dark w-25"><i class="fa-solid fa-greater-than fs-6"></i></button>
                        </div>
                    </div>
                    <table id="datatablesSimple">
                        <thead>
                        <tr>
                            <th>Ід</th>
                            <th>Покупець</th>
                            <th>Телефон</th>
                            <th>Адреса</th>
                            <th>Товари</th>
                            <th>Ціна замовлення</th>
                            <th>Дата</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Ід</th>
                            <th>Покупець</th>
                            <th>Телефон</th>
                            <th>Адреса</th>
                            <th>Товари</th>
                            <th>Ціна замовлення</th>
                            <th>Дата</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->pip }}</td>
                                <td>{{ $order->phone }}</td>
                                <td><button id="what" class="btn btn-outline-dark poshtaPopover" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="custom-popover" data-bs-title="{{ $order->type_poshta }}" data-bs-content="
                                    @if($order->type_poshta == "Нова Пошта" && $order->courier == false)
                                    {{ $order->nova_city . " - " . $order->nova_warehouse }}
                                    @elseif($order->type_poshta == "Нова Пошта" && $order->courier == true)
                                    {{ $order->nova_city . " Вулиця: " . $order->street . " Будинок: " . $order->house . " Квартира: " . ($order->room ? $order->room : "") }}
                                    @elseif($order->type_poshta == "Укр Пошта" && $order->courier == false)
                                    {{ $order->ukr_city . " - " . $order->ukr_post_office }}
                                    @elseif($order->type_poshta == "Укр Пошта" && $order->courier == true)
                                    {{ $order->ukr_city . " Вулиця: " . $order->street . " Будинок: " . $order->house . " Квартира: " . ($order->room ? $order->room : "") }}
                                    @endif" class="fw-bold text-dark">
                                        <img @if($order->type_poshta == "Нова Пошта")
                                             src="{{ asset("storage") . "/icons/nova.png" }}" class="icon-nova"
                                             @else src="{{ asset("storage") . "/icons/ukr.png" }}" class="icon-ukr"
                                             @endif alt="{{ $order->id }}"> Адереса
                                    </button></td>
                                <td>
                                    <button data-url="{{ route("getOrderProducts") }}" type="button" class="btn btn-outline-dark btn-order-products" data-bs-toggle="modal" data-bs-target="#productModal"><i class="fa-solid fa-box"></i> Замовленя</button>
                                </td>
                                <td>{{ $order->price }} @if($order->promocode)<i class="fa-brands fa-gg-circle tooltipPromo promo-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="З промокодом: {{ $order->promocode }}"></i>@endif</td>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="productModalLabel"><i class="fa-solid fa-box"></i> Замовлені товари <i id="edit-order-btn" class="pointer fa-solid fa-pen-to-square"></i></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="me-2 ms-2">
                    <div id="edit-order-block" class="mt-2">
                        <h6 class="text-center">Редагування замовлення <i class="fa-solid fa-circle-xmark pointer"></i></h6>
                        <div class="input-group mt-2">
                            <input id="idProductOrderAdd" class="form-control" type="text" placeholder="ID товару">
                            <input id="countProductOrder" class="form-control" type="number" min="1" placeholder="Кількість">
                            <button id="addProductsBtnToOrder" class="btn btn-dark" data-url="{{ route("addProductToOrder") }}">+</button>
                            <span style="width: 10px"></span>
                            <input id="idProductOrderDelete" type="text" class="form-control" placeholder="ID товару">
                            <button id="removeProductBtnFromOrder" class="btn btn-danger" data-url="{{ route("removeProductFromOrder") }}">-</button>
                        </div>
                    </div>
                </div>
                <div id="product-body" class="modal-body" data-order="" data-product-url="{{ route("product", "") }}">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-order_products" data-bs-dismiss="modal">Закрити</button>
                </div>
            </div>
        </div>
    </div>
@endsection

