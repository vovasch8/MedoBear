@extends("layouts.admin")

@section("head")
    @yield("pre-head")
    @vite(['resources/css/styles.css', 'resources/js/datatables-simple.js', 'resources/js/tables.js'])
@endsection

@section("content")
    <main>
        <div class="content-body">
            <img class="preload" src="{{ asset("logo.png") }}" alt="Logo">
        </div>

        <div class="container-fluid px-4">
            <h1 class="mt-4">Дані</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.blade.php">Панель</a></li>
                <li class="breadcrumb-item active">Дані</li>
            </ol>
            <div class="card mb-4">
            </div>
            <div class="card mb-4">
                <div class="card-header d-flex">
                    <i class="fas fa-table me-1" style="font-size: xx-large"></i>
                    <select data-selected="{{ $typeTable }}" onchange="location = this.selectedOptions[0].getAttribute('data-href');" class="form-select w-25 float-end" name="typeData" id="typeTable">
                        <option value="orders" data-href="{{ route("admin.tables") }}">Замовлення</option>
                        <option value="products" data-href="{{ route("admin_tables.show_products") }}">Продукти</option>
                        <option value="messages" data-href="{{ route("admin_tables.show_messages") }}">Повідомлення</option>
                        <option value="promocodes" data-href="{{ route("admin_tables.show_promocodes") }}">Промокоди</option>
                        @can("view-admin", \Illuminate\Support\Facades\Auth::user())
                            <option value="categories" data-href="{{ route("admin_tables.show_categories") }}">Категорії</option>
                            <option value="users" data-href="{{ route("admin_tables.show_users") }}">Користувачі</option>
                        @endcan
                    </select>
                </div>
                <div class="card-body">
                    <div class="edit-block">
                        <div id="edit-form" class="input-group">
                            <span id="old-text"></span>
                            <input data-url="{{ route("admin_tables.edit_column_table") }}" id="edit-input" type="text" class="form-control w-75" placeholder="Редагування">
                        </div>
                    </div>
                    <table data-edited-column="{{ json_encode($editedColumns) }}" id="datatablesSimple" data-table="orders">
                        <thead>
                            @yield("thead")
                        </thead>
                        <tfoot>
                            @yield("thead")
                        </tfoot>
                        <tbody>
                            @yield("tbody")
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

            <div class="toast main-toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-warning">
                    <strong class="me-auto text-dark">Повідомлення</strong>
                    <small>щойно</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Введені невірні дані при редагуванні!
                </div>
            </div>
    </main>

    @yield("content-continue")
@endsection

