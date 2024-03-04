@extends("layouts.main")

@section("title") Контакти @endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="effect border-radius-10 bg-main contact-block ms-3 me-3">
                    <img class="avatar" src="{{ asset("storage") . "\logo.png" }}" alt="MedoBear">
                    <a href="{{ route("catalog") }}" class="text-center title-medobear fw-bold second-color fs-2">MedoBear</a>
                    <span class="text-center text-white fw-bold fs-5 mt-2 border-bottom-second">Пропозиції:</span>
                    <p class="text-center text-white fw-bold mt-3 mb-2 pb-3 border-bottom-second">1. Ваші товари можуть бути розміщені на цьому сайті!</p>
                    <p class="text-center text-white fw-bold mt-2 mb-2 pb-3 border-bottom-second">2. Продавайте товар з цього сайту і отримуйте до 30% доходу від продуктів!</p>
                    <p class="text-center text-white fw-bold mt-2 mb-2">3. Товар оптом із знижками до 30%!</p>
                </div>
            </div>
            <div class="col-6">
                <div class="contact-form p-3 border-radius-10 bg-main">
                    <form action="{{ route("sendMessage") }}" method="post">
                        @csrf
                        <h5 class="text-center fw-bold mb-3 fs-3 second-color">Зворотній зв'язок!</h5>
                        <input type="text" name="name" class="form-control mb-2 input-form" placeholder="Прізвище ім'я">
                        <input type="text" name="subject" class="form-control mb-2 input-form" placeholder="Тема">
                        <textarea name="text" id="message" cols="30" rows="9" class="form-control mb-2 input-form" placeholder="Повідомлення"></textarea>
                        <input name="phone" type="phone" class="form-control mb-2 input-form" placeholder="Телефон">
                        <button type="submit" id="sendMessage" class="btn btn-warning w-100 bg-second">Надіслати</button>
                        @if(session('result'))
                            <div class="alert alert-success mt-2 text-center" role="alert">
                                {{ session('result') }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
            <div class="col-3">
                <div class="ps-3 pe-3">
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
