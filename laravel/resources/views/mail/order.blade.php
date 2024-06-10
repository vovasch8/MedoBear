<style type="text/css">

</style>

<table role="presentation" width="100%">
    <tr>
        <td bgcolor="#2d3748" align="center" style="color: white;">
            <h4>Нове замовлення #{{ $order->id }} на сайті Medobear</h4>
        </td>
    </tr>
</table>

<table class="templateColumnContainer" role="presentation" width="100%">
    <tr>
        <td align="center" style="border: 2px solid black;">
            <h4>--Контакти покупця--</h4>
        </td>
        <td valign="top" align="center" style="border: 2px solid black;">
            <h4>--Відправка--</h4>
        </td>
    </tr>
    <tr>
        <td align="center" style="border: 2px solid black;">
            Покупець: {{ $order->pip }} <br>
            Телефон: {{ $order->phone }} <br>
            @if($order->promocode)
                Промокод: {{ $order->promocode }} <br>
                Знижка: {{ $order->discount . "%" }}
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

<table role="presentation" width="100%" style="padding-bottom: 15px;">
    <tr>
        <td align="center" colspan="4"><h4 style="background: #2d3748;color: white;">--Замовлені Товари--</h4></td>
    </tr>
    <tr>
        <td align="center" style="border: 2px solid black;"><h4>Товар</h4></td>
        <td align="center" style="border: 2px solid black;"><h4>Кількість</h4></td>
        <td align="center" style="border: 2px solid black;"><h4>Ціна шт.</h4></td>
        <td align="center" style="border: 2px solid black;"><h4>Посилання</h4></td>
    </tr>
    @foreach($products as $index => $product)
        <tr>
            <td valign="top" align="center" style="border: 2px solid black;">
                <h4>{{ $product->name . " - " .  $product->size }}</h4>
            </td>
            <td align="center" style="border: 2px solid black;">
                {{ $product->product_count }} шт. <br>
            </td>
            <td align="center" style="border: 2px solid black;">
                {{ $product->price }} грн. <br>
            </td>
            <td align="center" style="border: 2px solid black;">
                <a href="{{ urldecode(route("site.product", [$product->id, $product->size])) }}">
                    <button
                        style="font: inherit;background-color: #ffc106;border: none;padding: 10px;text-transform: uppercase;letter-spacing: 2px;font-weight: 900;color: white;border-radius: 5px;box-shadow: 3px 3px #ffc106; cursor: pointer;">
                        Товар на сайті
                    </button>
                </a>
            </td>
        </tr>
    @endforeach
</table>

<table role="presentation" width="100%">
    <tr>
        <td bgcolor="#2d3748" align="center" style="color: white; padding-bottom: 15px;">
            <h4>Подивитись на замовлення в адмін панелі</h4>
            <a href="{{ route("admin.admin") }}"><button style="font: inherit;background-color: #ffc106;border: none;padding: 10px;text-transform: uppercase;letter-spacing: 2px;font-weight: 900;color: white;border-radius: 5px;box-shadow: 3px 3px #ffc106;cursor: pointer;">
                    Адмін панель</button></a>
        </td>
    </tr>
</table>
