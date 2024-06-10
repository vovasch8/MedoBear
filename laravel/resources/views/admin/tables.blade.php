@extends("layouts.admin-table")

@section("thead")
    <tr>
        <th>Ід</th>
        <th>Покупець</th>
        <th>Телефон</th>
        <th>Адреса</th>
        <th>Товари</th>
        <th>Ціна замовлення</th>
        <th>Промокод</th>
        <th>Дата</th>
        <th>Дія</th>
    </tr>
@endsection
@section("tbody")
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
                         src="{{ asset("icons/nova.png") }}" class="icon-nova"
                         @else src="{{ asset("icons/ukr.png") }}" class="icon-ukr"
                         @endif alt="{{ $order->id }}"> Адереса
                </button></td>
            <td>
                <button data-url="{{ route("order.get_order_cart") }}" type="button" class="btn btn-outline-dark btn-order-products" data-bs-toggle="modal" data-bs-target="#productModal"><i class="fa-solid fa-box"></i> Замовлення</button>
            </td>
            <td>{{ $order->price }}</td>
            <td>@if($order->promocode)<i class="fa-brands fa-gg-circle tooltipPromo promo-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="З промокодом: {{ $order->promocode . " Знижка: " . \App\Models\Promocode::getDiscount($order->promocode) . "%"}}"></i>@else Немає @endif</td>
            <td>{{ $order->created_at }}</td>
            <td><div class="actions text-center"><i data-url="{{ route("admin_orders.delete_order") }}" class="fa-solid fa-trash"></i></div></td>
        </tr>
    @endforeach
@endsection

@section("content-continue")
    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="productModalLabel"><i class="fa-solid fa-box"></i> Замовлені товари</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="me-2 ms-2">
                    <div id="edit-order-block" class="mt-2">
                        <h6 class="text-center">Редагування замовлення <i id="closeEditBlock" class="fa-solid fa-circle-xmark pointer"></i></h6>
                    </div>
                </div>
                <div id="product-body" data-image-url="{{ asset('storage') . "/products/" }}" class="modal-body" data-order="" data-product-url="{{ route("site.product", ["", ""]) }}">

                </div>
                <div class="modal-footer">
                    <button onclick="document.location.reload();" type="button" class="btn btn-dark btn-order_products">Оновити</button>
                </div>
            </div>
        </div>
    </div>
@endsection
