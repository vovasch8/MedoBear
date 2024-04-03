@extends("layouts.admin-table")

@section("thead")
    <tr>
        <th>Ід</th>
        <th>Відправник</th>
        <th>Тема</th>
        <th>Повідомлення</th>
        <th>Телефон</th>
        <th>Дата</th>
        <th>Дія</th>
    </tr>
@endsection
@section("tbody")
    @foreach($messages as $message)
        <tr>
            <td>{{ $message->id }}</td>
            <td>{{ $message->name }}</td>
            <td>{{ $message->subject }}</td>
            <td>{{ $message->text }}</td>
            <td>{{ $message->phone }}</td>
            <td>{{ $message->created_at }}</td>
            <td><div class="actions text-center"><i data-url="{{ route("admin_messages.delete_message") }}" class="fa-solid fa-trash"></i></div></td>
        </tr>
    @endforeach
@endsection

@section("content-continue")

@endsection

