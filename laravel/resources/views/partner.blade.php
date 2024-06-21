@extends("layouts.main")

@section("title") Кабінет @endsection

@section("head")
    @vite([ 'resources/css/main.css', 'resources/js/main.js'])
@endsection

@section("content")
    <div class="container-fluid">
        <div class="row">
        <div class="col-12 col-lg-6">
            <div class="mb-3">
                <h5 class="text-center fw-bold text-muted">Партнерська програма</h5>
            </div>
            <hr>
            <div class="container">
            <div class="d-flex justify-content-between mt-2">
                <h5 class="fw-bold text-wa"><span class="text-warning">Користувач:&nbsp;</span>{{ $user->name }}</h5>
                <h5 class="fw-bold"><span class="text-warning">Рахунок:&nbsp;</span><span>{{ $account }}</span> грн.</h5>
            </div>
                <div>
                    <h5 class="fw-bold text-warning text-center">Партнерські посилання</h5>
                    <div class="alert alert-primary alert-link d-flex justify-content-between" role="alert">
                        <span>Виплата: При переході за партнерським посиланням партнеру начисляється 30% від всього замовлення!</span>
                    </div>
                    <div class="d-flex">
                        <select name="parner-link" id="partner-link" class="form-select">
                            <option value="{{ route("site.catalog") . '?partner=' . $user->id}}">Каталог</option>
                            <optgroup label="Категорії:">
                                @foreach($categories as $category)
                                    <option value="{{ route('site.current_catalog', [$category->id]) . '?partner=' . $user->id }}">{{$category->name}}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Продукти категорій:">
                                @foreach($categories as $category)
                                    <optgroup label="{{$category->name}}">
                                        @foreach($category->products as $product)
                                            @if($product->count)
                                                <option value="{{ urldecode(route("site.product", [$product->id, $product->count])) . '?partner=' . $user->id }} ">{{$product->name .' - '. $product->count .' - '. $product->price .'грн.'}}</option>
                                            @endif
                                            @if($product->count2)
                                                <option value="{{ urldecode(route("site.product", [$product->id, $product->count2])) . '?partner=' . $user->id}}">{{$product->name .' - '. $product->count2 .' - '. $product->price2 .'грн.'}}</option>
                                            @endif
                                            @if($product->count3)
                                                <option value="{{ urldecode(route("site.product", [$product->id, $product->count3])) . '?partner=' . $user->id}}">{{$product->name .' - '. $product->count3 .' - '. $product->price3 .'грн.'}}</option>
                                            @endif
                                            @if($product->count4)
                                                <option value="{{ urldecode(route("site.product", [$product->id, $product->count4])) . '?partner=' . $user->id}}">{{$product->name .' - '. $product->count4 .' - '. $product->price4 .'грн.'}}</option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </optgroup>
                        </select>
                        <input type="text" value="{{ route('site.catalog') . '?partner=' . $user->id}}" class="form-control ms-1 copy-url" readonly>
                        <button class="btn btn-warning ms-1 btn-copy"><i class="fas fa-copy"></i></button>
                    </div>
                </div>
                <hr class="mt-3">
                <div>
                    <div class="d-flex mt-3 justify-content-between mb-2">
                        <h5 class="fw-bold  text-warning">Статистика</h5>
                        <div data-url="{{ route("partner.show_links_stat") }}" class="pagination">
                            <button id="stat-prev" class="btn btn-warning me-2 btn-sm" disabled><i class="fas fa-chevron-circle-left"></i></button>
                            <button id="stat-next" class="btn btn-warning btn-sm"><i class="fas fa-chevron-circle-right"></i></button>
                        </div>
                    </div>
                    <div class="table-responsive stat-link-container">
                        <table class="w-100 table-bordered count-links" data-next-page="{{ $statLinks['nextPage'] }}" data-count-links="{{ count($statLinks['links']) }}" data-standart-count-links="{{ $standartLinks }}">
                            <tbody>
                                @foreach($statLinks['links'] as $key => $sLink)
                                    @if($sLink['count'])
                                        <tr>
                                            <th class="text-center">Посилання</th>
                                            <th class="text-center">Продано за весь час</th>
                                            <th class="text-center">Сума</td>
                                            <th class="text-center">Нараховано</th>
                                        </tr>
                                        <tr>
                                            <td rowspan="3">
                                                <span class="ms-2 fw-bold">{{ $sLink['name'] }}:</span>
                                                <div  class="ms-2 mt-2 me-2 alert alert-primary alert-link d-flex justify-content-between" role="alert">
                                                    <span class="stat-link">{{ $sLink['link'] }}</span>
                                                    <i class="fas fa-copy copy mt-1"></i>
                                                </div >
                                            </td>
                                            <td data-stat-value="{{ $sLink['name'] }}" data-stat-link="{{ $sLink['link'] }}" class="text-center">
                                                {{ $sLink['count'] }}зам. <i class="fas fa-eye mt-1 watch show-order-icon"></i>
                                            </td>
                                            <td class="text-center">
                                                {{ $sLink['all_price'] }}грн.
                                            </td>
                                            <td class="text-center">
                                                {{ $sLink['payments'] }}грн.
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Останні продажі</th>
                                            <th class="text-center">Сума</th>
                                            <th class="text-center">Нараховано</th>
                                        </tr>
                                        <tr>
                                            <td data-stat-value="{{ $sLink['name'] }}" data-stat-link="{{ $sLink['link'] }}" class="text-center">
                                                {{ $sLink['paid_count'] }}зам. <i class="fas fa-eye mt-1 watch show-order-icon-last"></i>
                                            </td>
                                            <td class="text-center">
                                                {{ $sLink['paid_all_price'] }}грн.
                                            </td>
                                            <td class="text-center">
                                                {{ $sLink['paid_payments'] }}грн.
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="w-100 table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center">Всього замовлень</th>
                                <th class="text-center">Продано товару</th>
                                <th class="text-center">Сума</th>
                                <th class="text-center">Нараховано за весь час</th>
                                <th class="text-center">Виплачено</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center">
                                    {{ $statLinks['count'] }}шт.
                                </td>
                                <td class="text-center">
                                    {{ $statLinks['count_products'] }}шт.
                                </td>
                                <td class="text-center">
                                    {{ $statLinks['all_price'] }}грн.
                                </td>
                                <td class="text-center">
                                    {{ $statLinks['payments'] }}грн.
                                </td>
                                <td class="text-center">
                                    {{ $statLinks['paid_out'] }}грн.
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(!(Auth::user()->role == "admin" && isset($_GET['partner_id'])))
                    <hr class="mt-3">
                    <div class="mb-3">
                        <h5 class="fw-bold mt-3 text-warning">Виплати</h5>
                        <div class="alert alert-primary alert-link d-flex justify-content-between" role="alert">
                            <span>Начислення: Виплати проводяться 2 рази на місяць 1 та 15 числа на карту!</span>
                        </div>
                        <div class="card-number d-flex w-50">
                            <input value="{{ $user->card }}" @if($user->card) disabled @endif type="tel" class="form-control card-input" placeholder="Номер карти для нарахувань" inputmode="numeric" pattern="[0-9\s]{13,19}" maxlength="19">
                            <button data-url="{{ route("partner.save_card") }}" class="ms-1 btn btn-warning btn-card"><i class="fas @if(!$user->card)fa-credit-card @else fa-edit @endif"></i></button>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <h5 class="fw-bold mt-3 text-warning">Сповіщення в телеграм</h5>
                        <div class="alert alert-primary alert-link" role="alert">
                            <span class="fw-bold">Підключіть сповіщення про замовлення і нарахування в телеграм.</span><br>
                            <span class="fw-bold">1. Створіть групу та додайте в неї @medo_bear_bot.</span><br>
                            <span class="fw-bold">2. Перейменуйте посилання групи та вставте сюди в форматі @yourgroup і збережіть.</span>
                        </div>
                        <div class="card-number d-flex w-50">
                            <input value="{{ $user->telegram_group }}" @if($user->telegram_group) disabled @endif type="text" class="form-control group-input" placeholder="Посилання групи: @yourgroup">
                            <button data-url="{{ route("partner.save_group") }}" class="ms-1 btn btn-warning btn-group"><i class="mt-1 @if(!$user->telegram_group)fab fa-telegram @else fas fa-edit @endif"></i></button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="d-flex justify-content-between mb-2 page-block" data-url="{{ route("partner.show_orders") }}">
                <button id="prev" class="btn btn-warning ms-3 btn-sm" disabled><i class="fas fa-chevron-circle-left"></i></button>
                <h5 data-link="" data-last="false" class="text-center fw-bold text-muted order-type">Всі замовлення</h5>
                <button id="next" class="btn btn-warning me-3 btn-sm"><i class="fas fa-chevron-circle-right"></i></button>
            </div>
            <hr>
            <div class="row">
                <div class="main-row pe-5 container-empty text-center" @if($orders->isEmpty()) style="display: block;" @else style="display: none;" @endif>
                    <img class="empty-orders" src="{{ asset('icons') . "/empty.png" }}" alt="Пусто"><br>
                    <h4 class="text-muted mt-2">Замовлень немає!</h4>
                </div>
                <div class="orders-container">
                    <div class="count-orders row" data-next-page="{{ $orders->nextPage }}" data-count-orders="{{ count($orders) }}" data-standart-count="{{ $standart }}">
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
                                        <img class="productImage mx-auto" src="{{ asset('storage') . '/products/' . $product->product_id . '/' . $product->images[0]->image }}" alt="Order">
                                        <h6 class="mt-1 text-center bg-warning d-flex justify-content-center"><span class="bg-warning">{{$product->size . '-' . $product->price . 'грн.'}}</span></h6>
                                        <h6 class="text-center mt-0">{{ $product->count . 'шт.' }}</h6>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                         @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
