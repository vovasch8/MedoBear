@extends("layouts.admin-table")

@section("thead")
    <tr>
        <th>Ід</th>
        <th>Назва</th>
        <th>Опис</th>
        <th>Кількість</th>
        <th>Ціна</th>
        <th>Фото</th>
        <th>Активний</th>
        <th>Дата створення</th>
    </tr>
@endsection
@section("tbody")
    @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->count }}</td>
            <td>{{ $product->price }}</td>
            <td><button class="btn btn-dark">Фото</button></td>
            <td>{{ $product->active }}</td>
            <td>{{ $product->created_at }}</td>
        </tr>
    @endforeach
@endsection

@section("content-continue")

@endsection

