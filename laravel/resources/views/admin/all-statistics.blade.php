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
            <h1 class="mt-4">Загальна статистика</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route("admin.admin") }}">Панель</a></li>
                <li class="breadcrumb-item active">Загальна статистика</li>
            </ol>
            <div class="row">
                <div class="table-responsive">
                    <h5>Замовлення</h5>
                    <table class="table table-bordered text-center bg-success text-white">
                        <thead>
                            <tr>
                                <th>Всього замовлень</th>
                                <th>Замовлень з промокодом</th>
                                <th>Всього продано товарів</th>
                                <th>Сума</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $stats['count_orders'] }}</td>
                                <td>{{ $stats['count_orders_with_promocode'] }}</td>
                                <td>{{ $stats['count_products'] }}</td>
                                <td>{{ $stats['total_price'] }}грн.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive mt-3">
                    <h5>Партнери</h5>
                    <table class="table table-bordered text-center bg-primary text-white">
                        <thead>
                            <tr>
                                <th>Кількість партнерів</th>
                                <th>Замовлень через партнерів</th>
                                <th>Сума</th>
                                <th>Виплачено партнерам</th>
                                <th>Виплатити партнерам</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive mt-3">
                    <h5>Користувачі</h5>
                    <table class="table table-bordered text-center bg-warning text-white">
                        <thead>
                        <tr>
                            <th>Кількість користувачів</th>
                            <th>Замовлень користувачів</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $stats['count_users'] }}</td>
                                <td>{{ $stats['count_user_orders'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
