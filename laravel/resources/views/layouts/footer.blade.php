<footer class="py-3 mt-4 border-top border-top-3 border-warning">
    <ul class="nav justify-content-center pb-3 mt-2 w-nav">
        <li class="nav-item"><a href="{{ route('site.catalog') }}" class="nav-link px-2 text-warning fw-bold">Каталог товарів</a></li>
        <li class="nav-item"><a href="{{ route('site.delivery') }}" class="nav-link px-2 text-warning fw-bold">Доставка і оплата</a></li>
        <li class="nav-item"><a href="{{ route('site.about_us') }}" class="nav-link px-2 text-warning fw-bold">Про нас</a></li>
        <li class="nav-item"><a href="{{ route("site.contacts") }}" class="nav-link px-2 text-warning fw-bold">Контакти</a></li>
    </ul>
    <div id="social" class="d-flex justify-content-center mb-2">
        <a href="https://www.facebook.com/profile.php?id=61557616115991"><i class="fab fa-facebook fa-lg"></i></a>
        <a href="https://www.instagram.com/medo_b.e.a.r/"><i class="fab fa-instagram fa-lg"></i></a>
        <a href="https://t.me/Med_o_Bear"><i class="fab fa-telegram fa-lg"></i></a>
    </div>
    <p class="text-center text-warning fw-bold">© {{ date("Y") }} MedoBear</p>
</footer>
