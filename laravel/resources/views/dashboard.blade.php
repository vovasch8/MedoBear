@extends("layouts.main")

@section("title") Кабінет @endsection

@section("content")
    <div class="row">
        <div class="col-6">
            <h5 class="text-center">Мої замовлення</h5>
            <hr>
            <div class="row mt-2">
                @foreach($orders as $order)
                    <div class="col-sm-12 col-md-6">
                        <div class="card mb-3 me-2 ms-2">
                            <h6 class="ms-3 fw-bold mt-2 text-center">Замовлення: #{{ $order->id }}</h6>

                            <div class="accordion" id="accordionOrders">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$order->order_id}}" aria-expanded="true" aria-controls="collapse{{$order->order_id}}">
                                            <h6 class="text-center fw-bold">Інформація</h6>
                                        </button>
                                    </h2>
                                    <div id="collapse{{$order->order_id}}" class="accordion-collapse collapse" data-bs-parent="#accordionOrders">
                                        <div class="info ps-2 pe-2">
                                            <table class="templateColumnContainer mt-2" role="presentation" width="100%">
                                                <tr>
                                                    <td align="center" style="border: 2px solid black;">
                                                        <h6>--Контакти покупця--</h6>
                                                    </td>
                                                    <td valign="top" align="center" style="border: 2px solid black;">
                                                        <h6>--Відправка--</h6>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="border: 2px solid black;">
                                                        Покупець: {{ $order->pip }} <br>
                                                        Телефон: {{ $order->phone }} <br>
                                                        @if($order->promocode)
                                                            Промокод: {{ $order->promocode }} <br>
                                                            Знижка: {{ \App\Models\Promocode::getDiscount($order->promocode) . "%" }}
                                                        @endif
                                                    </td>
                                                    <td valign="top" align="center" style="border: 2px solid black;">
                                                        @if ($order->type_poshta == "Нова Пошта")
                                                            Пошта: Нова пошта <br>
                                                            @if ($order->courier)
                                                                --Відправити кур'єром по адресу-- <br>
                                                                Населений пункт: {{ $order->nova_city }} <br>
                                                                Вулиця: {{ $order->street }} <br>
                                                                Будинок: {{ $order->house }} <br>
                                                                @if ($order->room)
                                                                    Квартира: {{ $order->room }} <br>
                                                                @endif
                                                            @else
                                                                --Відправити у відділення-- <br>
                                                                Населений пункт: {{ $order->nova_city }} <br>
                                                                Відділення: {{ $order->nova_warehouse }} <br>
                                                            @endif
                                                        @else
                                                            Пошта: Укр пошта <br>
                                                            @if ($order->courier)
                                                                --Відправити кур'єром по адресу-- <br>
                                                                Населений пункт: {{ $order->ukr_city }} <br>
                                                                Вулиця: {{ $order->street }} <br>
                                                                Будинок: {{ $order->house }} <br>
                                                                @if ($order->room)
                                                                    Квартира: {{ $order->room }} <br>
                                                                @endif
                                                            @else
                                                                --Відправити у відділення-- <br>
                                                                Населений пункт: {{ $order->ukr_city }} <br>
                                                                Відділення: {{ $order->ukr_post_office }} <br>
                                                            @endif
                                                        @endif
                                                        Ціна замовлення: {{ $order->price }} грн.
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h6 class=" mt-2 ms-2 fw-bold text-center">Продукти</h6>
                            <hr>
                            <div class="d-flex justify-content-evenly mt-3">
                                @foreach($order->products as $product)
                                    <a class="d-flex justify-content-center text-center flex-column link-dark" href="{{ route("site.product", [$product->id, $product->size]) }}">
                                        <img class="productImage" src="{{ asset('storage') . '/products/' . $product->product_id . '/' . $product->images[0]->image }}" alt="Order">
                                        <h6 class="text-center">{{$product->size . '-' . $product->price . 'грн.'}}</h6>
                                        <h6 class="text-center">{{ $product->count . 'шт.' }}</h6>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-6">
            <h5 class="text-center">Партнерська програма</h5>
            <hr>
        </div>
    </div>
@endsection
