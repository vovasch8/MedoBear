@extends("layouts.admin")

@section("head")
    @vite(['resources/css/styles.css', 'resources/js/scripts.js'])
@endsection

@section("content")
    <main>
        <div class="content-body">
            <img class="preload" src="{{ asset("logo.png") }}" alt="Logo">
        </div>

        <div class="container-fluid px-4 mt-4">
            <h1 class="mt-4">Статистика товарів</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route("admin.admin") }}">Панель</a></li>
                <li class="breadcrumb-item active">Статистика товарів</li>
            </ol>
            <div class="row">
                <div class="table-responsive mt-3">
                    <h5><i class="fab fa-product-hunt"></i>&nbsp;Товари</h5>
                    <table class="table table-bordered text-center bg-success text-white">
                        <thead>
                        <tr>
                            <th>Назва</th>
                            <th>Розміри</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stats["stats_products"] as $id => $product)
                            <tr>
                                <td class="fw-bold">{{ $product['sizes'][0]["name"] }}</td>
                                <td>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Розмір</th>
                                            <th>Кількість продажів</th>
                                            <th>Сума продажів</th>
                                        </tr>
                                        @foreach($product['sizes'] as $value)
                                            <tr>
                                                <td>{{ $value["size"] }}</td>
                                                <td>{{ $value["count_products"] }}</td>
                                                <td>{{ $value["total_price"] . "грн."}}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="fw-bold">Загалом</td>
                                            <td class="fw-bold">{{ $product["total_count_products"] }}</td>
                                            <td class="fw-bold">{{ $product["total_price"] . "грн."}}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
