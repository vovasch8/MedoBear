@extends("layouts.admin")

@section("head")
    @vite(['resources/css/styles.css', 'resources/js/scripts.js', 'resources/js/chart-area.js', 'resources/js/chart-bar.js', 'resources/js/chart-bar.js', 'resources/js/datatables-simple.js', 'resources/js/chart-pie.js'])
@endsection

@section("content")
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Панель</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Панель</li>
            </ol>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4 d-flex">
                        <div class="card-body">Категорії
                            <div id="add-category-plus" class="small text-white float-end pointer"><i class="fas fa-plus"></i></div>
                            <div class="add-category-block card">
                                <div class="card-header fw-bold bg-dark text-white mb-2 d-flex justify-content-between"><span>Додавання категорії: </span><div class="category-loader"></div></div>
                                <div class="d-block">
                                    <input placeholder="Назва" class="form-control mb-2" type="text" name="category" id="add-name-category-input">
                                    <input placeholder="Іконка" type="file" accept="image/*" class="form-control mb-2" id="add-image-category-input">
                                    <div class="d-flex justify-content-between">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" checked id="isActiveCategory">
                                            <label class="form-check-label" for="isActiveCategory">Активна</label>
                                        </div>
                                        <button id="add-category-btn" data-url="{{ route("admin_categories.add_category") }}" class="btn btn-dark float-end">Додати</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="add-category-footer" class="card-footer">
                            @foreach($categories as $category)
                                <div id="c-{{ $category->id }}" class="card text-white bg-primary p-2 mb-1 pointer">
                                    {{ $category->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4 d-flex">
                        <div class="card-body">Продукти
                            <div id="add-product-plus" class="small text-white float-end pointer"><i class="fas fa-plus"></i></div>
                            <div class="add-product-block card">
                                <div class="card-header fw-bold bg-dark text-white mb-2 d-flex justify-content-between"><span>Додавання продукту: </span><div class="product-loader"></div></div>
                                <div class="d-block">
                                    <input placeholder="Назва" class="form-control mb-2" type="text" name="category" id="add-product-name">
                                    <textarea name="description" class="form-control mb-2" id="add-product-description" placeholder="Опис" rows="3"></textarea>
                                    <div class="input-group mb-2">
                                        <input id="add-product-count" type="text" class="form-control" name="count" placeholder="Кількість">
                                        <input id="add-product-price" type="text" class="form-control" name="price" placeholder="Ціна">
                                    </div>
                                    <h6>Категорія: </h6>
                                    <select id="add-product-category" name="product-category" class="form-select mb-2">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <h6>Фото: </h6>
                                    <input placeholder="Фото" type="file" multiple accept="image/*" class="form-control mb-2" id="add-product-image">
                                    <div class="d-flex justify-content-between">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" checked id="is-active-product">
                                            <label class="form-check-label" for="isActiveProduct">Активний</label>
                                        </div>
                                        <button id="add-product-btn" data-url="{{ route("admin_products.add_product") }}" class="btn btn-dark float-end">Додати</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="add-product-footer" class="card-footer">
                            @foreach($products as $product)
                                <div id="p-{{ $product->id }}" class="card text-white bg-warning p-2 mb-1 pointer">
                                    {{ $product->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4 d-flex">
                        <div class="card-body">Замовлення
                            <div class="small text-white float-end pointer"><a class="text-white text-decoration-none" href="#order-table"><i class="fas fa-angle-right"></i></a></div>
                        </div>
                        <div class="card-footer">
                            @foreach($lastOrders as $order)
                                <div id="o-{{ $order->id }}" class="card text-white bg-success p-2 mb-1 pointer">
                                    Замовлення #{{ $order->id }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4 d-flex">
                        <div class="card-body">Повідомлення
                            <div class="small text-white float-end pointer"><a class="text-white text-decoration-none" href="{{ route("admin.tables") }}"><i class="fas fa-angle-right"></i></a></div>
                        </div>
                        <div class="card-footer">
                            @foreach($messages as $message)
                                <div id="m-{{ $message->id }}" class="card text-white bg-danger p-2 mb-1 pointer">
                                    {{ $message->subject }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Останні продажі за місяць
                        </div>
                        <div class="card-body">
                            <canvas data-w1="{{ $countOrdersThisMonth['week1'] }}" data-w2="{{ $countOrdersThisMonth['week2'] }}" data-w3="{{ $countOrdersThisMonth['week3'] }}"
                                    data-w4="{{ $countOrdersThisMonth['week4'] }}" data-w5="{{ $countOrdersThisMonth['week5'] }}" data-count-days="{{ $countOrdersThisMonth["count_days"] }}"
                                    id="myAreaChart" width="100%" height="40">
                            </canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Останні продажі за 6 місяців
                        </div>
                        <div class="card-body"><canvas <?php $i = 1;?> @foreach($countOrdersBy6Month as $key => $m) data-m{{$i}}="{{$key}}" data-mv{{$i}}="{{$m}}" <?php $i++; ?>@endforeach id="myBarChart" width="100%" height="40"></canvas></div>
                    </div>
                </div>
            </div>
            <div id="order-table" class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Замовлення
                </div>
                <div class="card-body">
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
                                    <button data-url="{{ route("order.get_order_products") }}" type="button" class="btn btn-outline-dark btn-order-products" data-bs-toggle="modal" data-bs-target="#productModal"><i class="fa-solid fa-box"></i> Замовленя</button>
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
                    <h1 class="modal-title fs-5" id="productModalLabel"><i class="fa-solid fa-box"></i> Замовлені товари</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="product-body" class="modal-body" data-order="" data-product-url="{{ route("site.product", "") }}">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-order_products" data-bs-dismiss="modal">Закрити</button>
                </div>
            </div>
        </div>
    </div>
@endsection

