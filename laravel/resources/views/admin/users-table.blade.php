@extends("layouts.admin-table")

@section("thead")
    <tr>
        <th>Ід</th>
        <th>Повне ім'я</th>
        <th>Email</th>
        <th>Роль</th>
        <th>Дата реєстрації</th>
    </tr>
@endsection
@section("tbody")
    @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>{{ $user->created_at }}</td>
        </tr>
    @endforeach
@endsection

@section("content-continue")

@endsection

