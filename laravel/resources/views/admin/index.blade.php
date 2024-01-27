@extends("layouts.admin")

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
                            <div class="small text-white float-end pointer"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="card-footer">
                            @foreach($categories as $category)
                                <div id="c-{{ $category->id }}" class="card bg-primary p-2 mb-1 pointer">
                                    {{ $category->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4 d-flex">
                        <div class="card-body">Продукти
                            <div class="small text-white float-end pointer"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="card-footer">
                            @foreach($products as $product)
                                <div id="c-{{ $product->id }}" class="card bg-warning p-2 mb-1 pointer">
                                    {{ $product->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4 d-flex">
                        <div class="card-body">Замовлення
                            <div class="small text-white float-end pointer"><i class="fas fa-angle-right"></i></div>
                        </div>
                        <div class="card-footer">
                            @foreach($lastOrders as $order)
                                <div id="c-{{ $order->id }}" class="card bg-success p-2 mb-1 pointer">
                                    Замовлення #{{ $order->id }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4 d-flex">
                        <div class="card-body">Повідомлення
                            <div class="small text-white float-end pointer"><i class="fas fa-angle-right"></i></div>
                        </div>
                        <div class="card-footer">

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
                        <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Останні продажі за 6 місяців
                        </div>
                        <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
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
                                <td></td>
                                <td>{{ $order->price }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

