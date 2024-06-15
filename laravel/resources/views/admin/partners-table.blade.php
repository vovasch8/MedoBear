@extends("layouts.admin-table")

@section("thead")
    <tr>
        <th>Ід</th>
        <th>Повне ім'я</th>
        <th>Email</th>
        <th>Карта</th>
        <th>Замовлень</th>
        <th>Продано товару на</th>
        <th>Нараховано</th>
        <th>Останні замовлення</th>
        <th>Останні продажі</th>
        <th>Оплатити</th>
        <th>Дата реєстрації</th>
        <th>Дія</th>
        <th>Перегляд</th>
    </tr>
@endsection
@section("tbody")
    @foreach($partners as $key => $partner)
        <tr>
            <td>{{ $key }}</td>
            <td>{{ $partner['name'] }}</td>
            <td>{{ $partner['email'] }}</td>
            <td>{{ $partner['card'] }}</td>
            <td>{{ $partner['count_orders'] }}</td>
            <td>{{ $partner['non_price'] + $partner['done_price'] }}</td>
            <td>{{ $partner['non_payments'] + $partner['done_payments'] }}</td>
            <td>{{ $partner['done_count_orders'] }}</td>
            <td>{{ $partner['done_price'] }}</td>
            <td>{{ $partner['done_payments'] }}</td>
            <td>{{ $partner['created_at'] }}</td>
            <td><button data-url="{{ route('admin_partners.pay') }}" class="btn btn-dark btn-pay">Оплатити</button></td>
            <td><a href=" {{ route("partner.partner") . "?partner_id=" . $key }}" class="btn btn-dark">Кабінет</a></td>
        </tr>
    @endforeach
@endsection

@section("content-continue")

@endsection

