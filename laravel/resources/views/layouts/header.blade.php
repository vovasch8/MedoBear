<header class="border-bottom-3 d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-2 mb-4 border-bottom border-warning">

    <a href="{{ route('catalog') }}" class="d-flex logo">
        <img class="ms-5" id="logo" src="{{ asset('storage') . '/logo.png' }}" alt="MedoBear">
        <h5 class="text-warning fw-bold mt-3 ms-2">MedoBear</h5>
    </a>

    <ul class="nav col-12 col-md-auto  justify-content-center mb-md-0 w-nav">
        <li><a href="{{ route('catalog') }}" class="nav-link px-2 text-warning fw-bold">Каталог товарів</a></li>
        <li><a href="#" class="nav-link px-2 text-warning fw-bold">Співробітництво</a></li>
        <li><a href="#" class="nav-link px-2 text-warning fw-bold">Про нас</a></li>
        <li><a href="#" class="nav-link px-2 text-warning fw-bold">Контакти</a></li>
    </ul>


    <div class="col-md-3 text-end">
        <a href="{{ route('cart') }}" id="cart" class="me-2 text-warning  me-5"><i class="fas fa-shopping-basket"></i><span style="@if(session()->has('products')) display:inline-block; @endif" id="productCounter">{{ \App\Http\Controllers\CartController::countItems() }}</span></a>
        <a id="signIn" class="me-2 text-warning  me-5"><i class="fas fa-sign-in-alt"></i></a>
    </div>
</header>
