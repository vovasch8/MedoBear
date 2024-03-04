@extends("layouts.admin-table")

@section("thead")
    <tr>
        <th>Ід</th>
        <th>Категорія</th>
        <th>Іконка</th>
        <th>Дата</th>
    </tr>
@endsection
@section("tbody")
    @foreach($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td><div class="btn btn-dark">Іконка</div></td>
            <td>{{ $category->created_at }}</td>
        </tr>
    @endforeach
@endsection

@section("content-continue")

@endsection

