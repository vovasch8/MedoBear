<h4>Нове замовлення #{{ $order->id }} на сайті Medobear</h4>

--Контакти покупця--
Покупець: {{ $order->pip }}
Телефон: {{ $order->phone }}

--Відправка--
@if ($order->typePoshta === "Нова пошта")
    Пошта: Нова пошта
    @if ($order->courier)
        --Відправити кур'єром по адресі--
        Населений пункт: {{ $order->nova_city }}
        Вулиця: {{ $order->street }}
        Будинок: {{ $order->house }}
        @if ($order->room)
            Квартира: {{ $order->room }}
        @endif
    @else
        --Відправити у відділення--
        Населений пункт: {{ $order->nova_city }}
        Відділення: {{ $order->nova_warehouse }}
    @endif
@else
    Пошта: Укр пошта
    @if ($order->courier)
        --Відправити кур'єром по адресі--
        Населений пункт: {{ $order->ukr_city }}
        Вулиця: {{ $order->street }}
        Будинок: {{ $order->house }}
        @if ($order->room)
            Квартира: {{ $order->room }}
        @endif
    @else
        --Відправити у відділення--
        Населений пункт: {{ $order->ukr_city }}
        Відділення: {{ $order->nova_post_office }}
    @endif
@endif

--Товари--
@foreach($products as $product)
    {{ $product->name + " " + $product->count}}
    Кількість: шт. {{ $product->count }}
    <img width="150px" height="150px" src="{{ $product->image }}" alt="{{ $product->name }}">
    Посилання: <a href="{{ route("product", $product->id) }}">Товар на сайті</a>
@endforeach

Подивитись на замовлення в адмін панелі: <a href="{{ route("admin-order", $order->id) }}">Адмін панель</a>
