<footer class="py-3 mt-4 border-top border-top-3 border-warning">
    <ul class="nav justify-content-center pb-3 mt-2 w-nav">
        <li class="nav-item"><a href="{{ route('catalog') }}" class="nav-link px-2 text-warning fw-bold">Каталог товарів</a></li>
        <li class="nav-item"><a href="{{ route('partnership') }}" class="nav-link px-2 text-warning fw-bold">Співробітництво</a></li>
        <li class="nav-item"><a href="#" class="nav-link px-2 text-warning fw-bold">Про нас</a></li>
        <li class="nav-item"><a href="{{ route("contacts") }}" class="nav-link px-2 text-warning fw-bold">Контакти</a></li>
    </ul>
    <div id="social" class="d-flex justify-content-center mb-2">
        <i class="fab fa-facebook fa-lg"></i>
        <i class="fab fa-instagram fa-lg"></i>
        <i class="fab fa-telegram fa-lg"></i>
    </div>
    <p class="text-center text-warning fw-bold">© {{ date("Y") }} MedoBear</p>
</footer>
