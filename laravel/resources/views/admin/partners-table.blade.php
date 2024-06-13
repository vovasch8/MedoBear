@extends("layouts.admin-table")

@section("thead")
    <tr>
        <th>Ід</th>
        <th>Повне ім'я</th>
        <th>Email</th>
        <th>Карта</th>
        <th>Продано товару на</th>
        <th>Нараховано</th>
        <th>Останні продажі</th>
        <th>Оплатити</th>
        <th>Дата реєстрації</th>
        <th>Дія</th>
    </tr>
@endsection
@section("tbody")
    @foreach($partners as $key => $partner)
        <tr>
            <td>{{ $key }}</td>
            <td>{{ $partner['name'] }}</td>
            <td>{{ $partner['email'] }}</td>
            <td>{{ $partner['card'] }}</td>
            <td>{{ $partner['non_price'] }}</td>
            <td>{{ $partner['non_payments'] }}</td>
            <td>{{ $partner['done_price'] }}</td>
            <td>{{ $partner['done_payments'] }}</td>
            <td>{{ $partner['created_at'] }}</td>
            <td><button class="btn btn-dark">Оплатити</button></td>
        </tr>
    @endforeach
@endsection

@section("content-continue")

@endsection

