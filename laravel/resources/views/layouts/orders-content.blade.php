<div class="count-orders row" data-next-page="{{ $orders->nextPage }}" data-count-orders="{{ count($orders) }}" data-standart-count="{{ $standart }}">
    @if (!count($orders))
        <div class="main-row pe-5 container-empty text-center mt-3">
            <img class="empty-orders" src="{{ asset('icons') . "/empty.png" }}" alt="Пусто"><br>
        </div>
    @endif
    @foreach($orders as $key => $order)
        <div class="col-sm-12 col-md-6 col-lg-12 col-xl-6 mt-2">
            <div class="card mb-3 me-2 ms-2">
                <h6 class="ms-3 fw-bold mt-2 text-center">Замовлення: #{{ $order->id }}</h6>

                <div class="accordion" id="accordionOrders{{$key}}">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button bg-warning" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$order->order_id}}" aria-expanded="true" aria-controls="collapse{{$order->order_id}}">
                                <h6 class="text-center fw-bold">Інформація</h6>
                            </button>
                        </h2>
                        <div id="collapse{{$order->order_id}}" class="accordion-collapse collapse show" data-bs-parent="#accordionOrders{{$key}}">
                            <div class="info ps-2 pe-2">
                                <table class="templateColumnContainer mt-3" role="presentation" width="100%">
                                    <tr>
                                        <td align="center" style="border: 2px solid black;">
                                            <h6>Покупець</h6>
                                        </td>
                                        <td valign="top" align="center" style="border: 2px solid black;">
                                            <h6>Сума замовлення</h6>
                                        </td>
                                        <td valign="top" align="center" style="border: 2px solid black;">
                                            <h6>Нараховано</h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="border: 2px solid black;">
                                            {{ $order->pip }} <br>
                                        </td>
                                        <td valign="top" align="center" style="border: 2px solid black;">
                                            {{ $order->price }} грн.
                                            @if($order->promocode)
                                                <br>З промокодом: {{ $order->promocode }} <br>
                                                Знижка: {{ \App\Models\Promocode::getDiscount($order->promocode) . "%" }}
                                            @endif
                                        </td>
                                        <td  align="center" style="border: 2px solid black;">
                                            {{ round($order->price * 0.3) }}грн.
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <h6 class=" mt-2 ms-2 fw-bold text-center">Продукти</h6>
                <hr>
                <div class="row mt-3 ps-2 pe-2 d-flex justify-content-center">
                    @foreach($order->products as $product)
                        <a data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="{{ $product->name }}" class=" col-md-4 col-sm-3 col-xs-4 col-6 d-flex justify-content-center text-center flex-column link-dark tooltipOrder" href="{{ route("site.product", [$product->id, $product->size]) }}">
                            <img class="productImage mx-auto" src="{{ asset('storage') . '/products/' . $product->product_id . '/' . $product->images[0]->image }}" alt="{{ $product->name }}">
                            <h6 class="mt-1 text-center bg-warning d-flex justify-content-center"><span class="bg-warning">{{$product->size . '-' . $product->price . 'грн.'}}</span></h6>
                            <h6 class="text-center mt-0">{{ $product->count . 'шт.' }}</h6>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
