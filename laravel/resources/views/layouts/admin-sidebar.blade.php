<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Меню</div>
                <a class="nav-link" href="{{ route("admin") }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Панель
                </a>
                <a class="nav-link" href="{{ route("admin-tables") }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Дані
                </a>
                <div class="sb-sidenav-menu-heading">Статистика</div>
                <a class="nav-link" href="{{ route("admin-charts") }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Графіки
                </a>
                <div class="sb-sidenav-menu-heading">Основне</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a style="cursor: pointer;" class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">
                        <div class="sb-nav-link-icon"><i class="fas fa-sign-in"></i></div>
                        Вийти
                    </a>
                </form>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Користувач: @auth{{ \Illuminate\Support\Facades\Auth::user()->name }}@endauth</div>
        </div>
    </nav>
</div>
