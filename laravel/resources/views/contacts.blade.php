@extends("layouts.main")

@section("title") Контакти @endsection

@section("head")
    @vite([ 'resources/css/main.css', 'resources/js/main.js'])
@endsection

@section('seo-block')
    <meta name="description" content="Як можна зв'язатись з нами?">
    <meta name="keywords" content="контакти медобір, контакти medobear, контакти, зворотній зв'язок, medobear">
    <meta name="author" content="MedoBear">

    <meta property="og:url" content="https://medo-bear.com/about-us">
    <meta property="og:type" content="Page">
    <meta property="og:title" content="Контакти">
    <meta property="og:description" content="Як можна зв'язатись з нами?">
    <meta property="og:image" content="{{ asset('logo.png') }}">
@endsection

@section("content")
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-12 order-md-1 order-lg-2">
                <div class="contact-form p-3 border-radius-10 bg-main mb-3">
                    <form action="{{ route("site.send_message") }}" method="post">
                        @csrf
                        <h5 class="text-center fw-bold mb-3 fs-3 second-color">Зворотній зв'язок!</h5>
                        <input value="{{ old('name') }}" type="text" name="name" class="form-control mb-2 input-form" placeholder="Прізвище ім'я">
                        <input value="{{ old('subject') }}" type="text" name="subject" class="form-control mb-2 input-form" placeholder="Тема">
                        <textarea name="text" id="message" cols="30" rows="9" class="form-control mb-2 input-form" placeholder="Повідомлення"></textarea>
                        <input value="{{ old('phone') }}" name="phone" type="number" class="form-control mb-2 input-form" placeholder="Телефон">
                        <button type="submit" id="sendMessage" class="btn btn-warning w-100 bg-second">Надіслати</button>
                        @if(session('result'))
                            <div class="alert alert-success mt-2 text-center" role="alert">
                                {{ session('result') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger mt-2 text-center">
                                <span class="fw-bold mb-2">Помилки:</span><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 order-md-2 order-lg-1 ">
                <div class="effect border-radius-10 bg-main contact-block ms-3 me-3 mb-3">
                    <img class="avatar" src="{{ asset("logo.png") }}" alt="MedoBear">
                    <a href="{{ route("site.catalog") }}" class="text-center title-medobear fw-bold second-color fs-2">MedoBear</a>
                    <span class="text-center text-white fw-bold fs-5 mt-2 border-bottom-second">Пропозиції:</span>
                    <p class="text-center text-white fw-bold mt-3 mb-2 pb-3 ps-1 pe-1 border-bottom-second">1. Ваші товари можуть бути розміщені на цьому сайті!</p>
                    <p class="text-center text-white fw-bold mt-2 mb-2 pb-3 ps-1 pe-1 border-bottom-second">2. Продавайте товар з цього сайту і отримуйте до 30% доходу від продуктів!</p>
                    <p class="text-center text-white fw-bold mt-2 mb-3 ps-1 pe-1">3. Товар оптом із знижками до 30%!</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 order-md-3 order-lg-3">
                <div class="ps-3 pe-3 mb-3">
                    <div class="contact-block border-radius-10 bg-main text-white">
                        <h5 class="text-center fw-bold mb-1 fs-5 second-color mt-3">Звернення:</h5>
                        <div class="contact-inner-block ps-4 pe-4 pb-3 fw-bold">
                            Будь-ласка опишіть суть вашого звернення,
                            чи це співпраця, чи просто відгук про товари!
                        </div>
                    </div>
                </div>
                <div class="ps-3 pe-3 mt-3">
                    <div class="contact-block border-radius-10 bg-main">
                        <h5 class="text-center fw-bold mb-3 fs-5 second-color mt-3">Соціальні мережі:</h5>
                        <div id="social" class="d-flex justify-content-center mb-2">
                            <i class="fab fa-facebook fa-lg"></i>
                            <i class="fab fa-instagram fa-lg"></i>
                            <i class="fab fa-telegram fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="ps-3 pe-3 mt-3">
                    <div class="contact-block border-radius-10 bg-main text-white">
                        <h5 class="text-center fw-bold mb-1 fs-5 second-color mt-3">Контакти:</h5>
                        <div class="contact-inner-block ps-4 pe-4 pb-3">
                            <span class="fw-bold second-color">Телефони:</span><br>
                            <span class="fw-bold">+380979612311,</span>
                            <span class="fw-bold">+380686274162</span><br>
                            <span class="fw-bold second-color">Email:</span><br>
                            <span class="fw-bold">vovasch8@gmail.com</span><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
