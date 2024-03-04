@extends("layouts.admin")

@section("head")
    @vite(['resources/css/styles.css', 'resources/js/datatables-simple.js', 'resources/js/tables.js'])
@endsection

@section("content")
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Таблиці</h1>
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
                        <option value="orders" data-href="{{ route("admin-tables") }}">Замовлення</option>
                        <option value="products" data-href="{{ route("productsTable") }}">Продукти</option>
                        <option value="messages" data-href="{{ route("messagesTable") }}">Повідомлення</option>
                        @can("view-admin", \Illuminate\Support\Facades\Auth::user())
                            <option value="categories" data-href="{{ route("categoriesTable") }}">Категорії</option>
                            <option value="users" data-href="{{ route("usersTable") }}">Користувачі</option>
                        @endcan
                    </select>
                </div>
                <div class="card-body">
                    <div class="edit-block">
                        <div id="edit-form" class="input-group">
                            <span id="old-text"></span>
                            <input data-url="{{ route("editColumnTable") }}" id="edit-input" type="text" class="form-control w-75" placeholder="Редагування">
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
    </main>

    @yield("content-continue")
@endsection

