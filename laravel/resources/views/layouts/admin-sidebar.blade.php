<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Меню</div>
                <a class="nav-link" href="{{ route("admin") }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Панель
                </a>
                <div class="sb-sidenav-menu-heading">Статистика</div>
                <a class="nav-link" href="{{ route("admin-charts") }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Графіки
                </a>
                <a class="nav-link" href="{{ route("admin-tables") }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Таблиці
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Користувач:</div>
            Medobear
        </div>
    </nav>
</div>
