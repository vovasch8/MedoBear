<header class="border-bottom-3 d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-2 mb-4 border-bottom border-warning">

    <div class="col-md-3 col-lg-2">
        <a href="{{ route('site.catalog') }}" class="d-flex logo">
            <img class="ms-4" id="logo" src="{{ asset('logo.png') }}" alt="MedoBear">
            <h5 class="text-warning fw-bold mt-3 ms-2">MedoBear</h5>
        </a>
    </div>

    <ul class="nav col-md-7 col-lg-8 col-12 col-md-auto nav-menu justify-content-center mb-md-0 w-nav">
        <li><a href="{{ route('site.catalog') }}" class="nav-link px-2 text-warning fw-bold">Каталог товарів</a></li>
        <li><a href="{{ route('site.delivery') }}" class="nav-link px-2 text-warning fw-bold">Доставка і оплата</a></li>
        <li><a href="{{ route('site.about_us') }}" class="nav-link px-2 text-warning fw-bold">Про нас</a></li>
        <li><a href="{{ route('site.contacts') }}" class="nav-link px-2 text-warning fw-bold">Контакти</a></li>
    </ul>


    <div class="col-md-2 col-lg-2 left-menu">
        <div class="d-flex justify-content-end">
            <div class="icon-block">
                <a href="{{ route('site.cart') }}" id="cart" class="text-warning"><i class="fas fa-shopping-basket"></i><span style="@if(session()->has('products')) display:inline-block; @endif" id="productCounter">{{ \App\Http\Controllers\CartController::countItems() }}</span></a>
            </div>
            @auth
                <div class="dropdown me-3">
                    <button class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-alt"></i></i>&nbsp;{{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route("profile.edit") }}"><i class="fas fa-user-circle text-muted"></i>&nbsp;Профіль</a></li>
                        <li><a class="dropdown-item" href="{{ route("dashboard") }}"><i class="fas fa-box text-muted"></i>&nbsp;Мої замовлення</a></li>
                        <li><a class="dropdown-item" href="{{ route("partner.partner") }}"><i class="fas fa-handshake text-muted"></i>&nbsp;Партнерка</a></li>
                        @can("view-manager", \Illuminate\Support\Facades\Auth::user())
                            <li><a class="dropdown-item" href="{{ route("admin.admin") }}"><i class="fas fa-tools text-muted"></i>&nbsp;Адмін панель</a></li>
                        @endcan
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <li onclick="event.preventDefault(); this.closest('form').submit();"><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt text-muted"></i>&nbsp;Вийти</a></li>
                        </form>
                    </ul>
                </div>
            @else
                <div class="icon-block">
                    <a id="signIn" href="{{ route('login') }}" class="text-warning"><i class="fas fa-sign-in-alt"></i></a>
                </div>
            @endauth
        </div>
    </div>
</header>
