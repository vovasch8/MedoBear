@extends("layouts.main")

@section("title") Кабінет @endsection

@section("head")
    @vite([ 'resources/css/main.css', 'resources/js/main.js'])
@endsection

@section("content")
    <div class="container-fluid">
            <h5 class="text-center fw-bold text-muted">Мої замовлення</h5>
            <hr>
            <div class="row">
                <span class="w-100 mt-3 mb-2 text-center link-warning">
                    {{ $orders->links() }}
                </span>
                <div class="main-row pe-5 container-empty text-center" @if($orders->isEmpty()) style="display: block;" @else style="display: none;" @endif>
                    <img class="empty-orders" src="{{ asset('icons') . "/empty.png" }}" alt="Пусто"><br>
                    <h4 class="text-muted mt-2">Замовлень немає!</h4>
                </div>
                @foreach($orders as $key => $order)
                    <div class="col-sm-12 col-md-6 col-lg-4 mt-2">
                        <div class="card mb-3 me-2 ms-2">
                            <h6 class="ms-3 fw-bold mt-2 text-center">Замовлення: #{{ $order->id }}</h6>

                            <div class="accordion" id="accordionOrders{{$key}}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header ">
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
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h6 class=" mt-2 ms-2 fw-bold text-center">Продукти</h6>
                            <hr>
                            <div class="row mt-3 ps-2 pe-2">
                                @foreach($order->products as $product)
                                    <a data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="{{ $product->name }}" class=" col-sm-3 col-lg-6 col-xs-6 col-6 col-md-4 col-xl-4 d-flex justify-content-center text-center flex-column link-dark tooltipOrder orderProduct" href="{{ route("site.product", [$product->id, $product->size]) }}">
                                        <img class="productImage mx-auto" src="{{ asset('storage') . '/products/' . $product->product_id . '/' . $product->images[0]->image }}" alt="Order">
                                        <h6 class="mt-1 text-center bg-warning d-flex justify-content-center"><span class="bg-warning">{{$product->size . '-' . $product->price . 'грн.'}}</span></h6>
                                        <h6 class="text-center">{{ $product->count . 'шт.' }}</h6>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    </div>
@endsection
