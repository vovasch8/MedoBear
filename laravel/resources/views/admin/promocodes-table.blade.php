@extends("layouts.admin-table")

@section("thead")
    <tr>
        <th>Ід</th>
        <th>Промокод</th>
        <th>Знижка(%)</th>
        <th>Активний до</th>
        <th>Дата реєстрації</th>
    </tr>
@endsection
@section("tbody")
    @foreach($promocodes as $promocode)
        <tr>
            <td>{{ $promocode->id }}</td>
            <td>{{ $promocode->promocode }}</td>
            <td>{{ $promocode->discount }}</td>
            <td>{{ $promocode->active_to }}</td>
            <td>{{ $promocode->created_at }}</td>
        </tr>
    @endforeach
@endsection

@section("content-continue")

@endsection
