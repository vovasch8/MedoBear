@extends("layouts.admin")

@section("head")
    @vite(['resources/css/styles.css', 'resources/js/charts.js', 'resources/js/chart-area.js', 'resources/js/chart-bar.js', 'resources/js/chart-bar.js', 'resources/js/chart-pie.js'])
@endsection

@section("content")
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Графіки</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route("admin") }}">Панель</a></li>
                <li class="breadcrumb-item active">Charts</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Останні продажі за місяць
                </div>
                <div class="card-body"><canvas data-w1="{{ $countOrdersThisMonth['week1'] }}" data-w2="{{ $countOrdersThisMonth['week2'] }}" data-w3="{{ $countOrdersThisMonth['week3'] }}"
                                               data-w4="{{ $countOrdersThisMonth['week4'] }}" data-w5="{{ $countOrdersThisMonth['week5'] }}" data-count-days="{{ $countOrdersThisMonth["count_days"] }}"
                                               id="myAreaChart" width="100%" height="30">

                    </canvas>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Останні продажі за 6 місяців
                        </div>
                        <div class="card-body"><canvas <?php $i = 1;?> @foreach($countOrdersBy6Month as $key => $m) data-m{{$i}}="{{$key}}" data-mv{{$i}}="{{$m}}" <?php $i++; ?>@endforeach
                            id="myBarChart" width="100%" height="50">
                            </canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-pie me-1"></i>
                            Найпопулярніші товари
                        </div>
                        <div class="card-body"><canvas <?php $i = 1;?> @foreach($mostPopularProducts as $m) data-m{{$i}}="{{$m->name}}" data-mv{{$i}}="{{$m->count}}" <?php $i++; ?>@endforeach id="myPieChart" width="100%" height="50"></canvas></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
