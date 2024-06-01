@extends("layouts.admin-table")

@section("right-block")
    <div class="w-100 text-end">
        <button class="btn btn-dark btn-add-promocode" data-bs-toggle="modal" data-bs-target="#promocodeModal"><i class="fa fa-plus"></i> Додати промокод</button>
    </div>
@endsection

@section("thead")
    <tr>
        <th>Ід</th>
        <th>Промокод</th>
        <th>Знижка(%)</th>
        <th>Активний до</th>
        <th>Дата реєстрації</th>
        <th>Дія</th>
    </tr>
@endsection
@section("tbody")
    @foreach($promocodes as $promocode)
        <tr>
            <td>{{ $promocode->id }}</td>
            <td>{{ $promocode->promocode }}</td>
            <td>{{ $promocode->discount }}</td>
            <td>{{ $promocode->active_to }}</td>
            <td>{{ $promocode->created_at }}</td>
            <td><div class="promos text-center"><i data-url="{{ route("admin_tables.delete_promocode") }}" class="fa-solid fa-trash"></i></div></td>
        </tr>
    @endforeach
@endsection

@section("content-continue")
    <!-- Modal -->
    <div class="modal fade" id="promocodeModal" tabindex="-1" aria-labelledby="promocodeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="promocodeModalLabel"><i class="fa-solid fa-receipt"></i> Додати промокод</h5>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">&nbsp;&nbsp;</button>
                    </div>
                <div class="modal-body">
                    <div class="">
                        <label class="fw-bold" for="promocode"><i class="fa-solid fa-receipt"></i> Промокод</label>
                        <input class="form-control mb-2" id="promocode" type="text" name="promocode" placeholder="Промокод">
                        <label class="fw-bold" for="discount"><i class="fa-solid fa-percent"></i> Знижка</label>
                        <input type="number" class="form-control mb-2" id="discount" name="discount" placeholder="Знижка">
                        <label class="fw-bold" for="discount"><i class="fa-solid fa-calendar"></i> Дійсний до</label>
                        <input type="date" class="form-control" id="endDate" name="end_date">
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-bs-dismiss="modal" data-url="{{ route("admin_tables.add_promocode") }}" class="btn btn-dark d-flex btn-add-promo"><i class="fa-solid fa-receipt mt-1 me-2"></i> Додати</button>
                </div>
            </div>
        </div>
    </div>
@endsection
