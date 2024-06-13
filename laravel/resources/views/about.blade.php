@extends("layouts.main")

@section("title") Про нас @endsection

@section("head")
    @vite([ 'resources/css/main.css', 'resources/js/main.js'])
@endsection

@section('seo-block')
    <meta name="description" content="Пасіка MedoBear. Про нас. Пасіка біля заповідника Медобори. На території заповідника існують різні види квітів з яких виходить корисний мед.">
    <meta name="keywords" content="про нас, про пасіку, про товари, про заповідник, медобір, medobear">
    <meta name="author" content="MedoBear">

    <meta property="og:url" content="https://medo-bear.com/about-us">
    <meta property="og:type" content="Page">
    <meta property="og:title" content="Про нас">
    <meta property="og:description" content="Пасіка MedoBear. Про нас. Пасіка біля заповідника Медобори. На території заповідника існують різні види квітів з яких виходить корисний мед.">
    <meta property="og:image" content="{{ asset('logo.png') }}">
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <h1 class="fw-bold h4 text-center">Про нас</h1>

                <hr>

                <h2 class="h5 mt-3">Особливості пасіки:</h2>

                <p class="text-justify"><span class="fw-bold">Пасіка з території Медоборів</span> - це особливе місце, яке розташоване на території заповідника, де процвітають різноманітні медоносні рослини, які служать джерелом нектару і пилку для бджіл, що дозволяє отримувати мед різних сортів і смаків з унікальними властивостями.</p>

                <h2 class="h5">Процеc збирання меду:</h2>

                <div>
                    <ul>
                        <li class="text-justify"><span class="fw-bold">Збирання нектару:</span> Бджоли вилітають з вулика та збирають нектар у свої корзинки.</li>

                        <li class="text-justify"><span class="fw-bold">Перенесення нектару у вулик:</span> Після збору нектару, бджоли повертаються до вулика, де перекладають нектар у комірки уздовж вулика.</li>

                        <li class="text-justify"><span class="fw-bold">Видобуток меду:</span> Пасічник обережно видаляє рамки з вулика та обрізає запаковані бджалами комірки.</li>

                        <li class="text-justify"><span class="fw-bold">Віджимання меду:</span> Комірки з медом піддаються віджиманню за допомогою спеціальних механізмів, які відокремлюють мед від віскового налипу.</li>

                        <li class="text-justify"><span class="fw-bold">Очищення та фільтрація:</span> Віджатий мед проймає процес фільтрації для видалення будь-яких непотрібних часток або домішок.</li>

                        <li class="text-justify"><span class="fw-bold">Розливка та упаковка:</span> Чистий мед розливають у скляні, пластикові або металеві контейнери.</li>
                    </ul>
                </div>
                <h2 class="h5">Продукти бджільництва:</h2>
                <p><span class="fw-bold">Бджільництво</span> — це дивовижне мистецтво, що дарує нам широкий спектр корисних продуктів, які охоплюють не лише смакові відчуття, а й користь для здоров'я. Ось деякі з них:</p>

                <ul>
                    <li class="text-justify"><span class="fw-bold">Мед:</span> Справжній мед є смаковим еліксиром, відомим своїм багатим смаком та ароматом. Цей природний продукт має безліч корисних властивостей: він багатий антиоксидантами, вітамінами та мінералами, сприяє покращенню імунітету та загалом позитивно впливає на здоров'я.</li>

                    <li class="text-justify"><span class="fw-bold">Пилок квітковий:</span> Пилок, зібраний бджолами з квітів, є джерелом багатьох вітамінів, мінералів та амінокислот. Він використовується як природна біологічно активна добавка до їжі, яка сприяє покращенню енергії, витривалості та загального стану здоров'я.</li>

                    <li class="text-justify"><span class="fw-bold">Віск:</span> Бджолиний віск використовується для виготовлення свічок, косметичних засобів, лікарських мазей та багатьох інших продуктів. Він має протизапальні та антибактеріальні властивості, що робить його цінним компонентом для багатьох галузей промисловості.</li>

                    <li class="text-justify"><span class="fw-bold">Прополіс:</span> Це смолоподібна речовина, яку бджоли збирають з пуп'янків дерев. Прополіс має потужні антибактеріальні, протизапальні та антисептичні властивості, що робить його корисним для лікування ран, захворювань дихальних шляхів та інших захворювань.</li>

                    <li class="text-justify"><span class="fw-bold">Маточне молочко:</span> Це продукт, що виділяється молодими бджолами. Маточне молочко містить унікальний комплекс вітамінів, мінералів та амінокислот, які сприяють загальному підвищенню тонусу та зміцненню імунітету.</li>
                </ul>
                <p class="text-justify">
                    Ці продукти бджільництва дарують нам природну силу та енергію, які допомагають підтримувати здоров'я та жити більш повноцінним життям.
                </p>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="row">
                    <div class="image-block row">
                        <div class="col-xl-6 col-lg-12 text-center">
                            <img class="about-image me-3 mb-3" src="{{ asset("about/1.jpg") }}" alt="Medobear">
                        </div>
                        <div class="col-xl-6 col-lg-12 text-center">
                            <img class="about-image mb-3" src="{{ asset("about/2.jpg") }}" alt="Medobear">
                        </div>
                    </div>
                    <div class="image-block row">
                        <div class="col-xl-6 col-lg-12 text-center">
                            <img class="about-image me-3 mb-3" src="{{ asset("about/3.jpg") }}" alt="Medobear">
                        </div>
                        <div class="col-xl-6 col-lg-12 text-center">
                            <img class="about-image mb-3" src="{{ asset("about/4.jpg") }}" alt="Medobear">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
