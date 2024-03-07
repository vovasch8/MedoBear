@extends("layouts.admin-table")

@section("thead")
    <tr>
        <th>Ід</th>
        <th>Категорія</th>
        <th>Іконка</th>
        <th>Активна</th>
        <th>Дата</th>
    </tr>
@endsection
@section("tbody")
    @foreach($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td><button data-src="{{ asset("storage") . "/icons/" . $category->image }}" class="btn btn-outline-dark btn-icon" data-bs-toggle="modal" data-bs-target="#iconModal"><i class="fa-solid fa-ice-cream"></i> Іконка</button></td>
            <td>
                <select data-url="{{ route("changeCategoryStatus") }}" class="form-select category-active" name="active">
                    <option value="1">Так</option>
                    <option {{ ($category->active == 0) ? "selected" : "" }} value="0">Ні</option>
                </select>
            </td>
            <td>{{ $category->created_at }}</td>
        </tr>
    @endforeach
@endsection

@section("content-continue")
    <!-- Modal -->
    <div class="modal fade" id="iconModal" tabindex="-1" aria-labelledby="iconModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="iconModalLabel">Іконка категорії</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="loader-img">
                        <img src="" alt="Icon" id="icon-img" class="mb-3">
                    </div>
                    <br>
                    <span class="fw-bold">Вибрати нову іконку:</span>
                    <div class="d-flex justify-content-center">
                        <input placeholder="Фото" type="file" accept="image/*" class="form-control mb-2" id="load-image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Закрити</button>
                    <button data-url="{{ route("updateCategoryImage") }}" type="button" class="btn btn-outline-dark btn-save-upload-image">Зберегти</button>
                </div>
            </div>
        </div>
    </div>
@endsection

