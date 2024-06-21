@extends("layouts.admin-table")

@section("thead")
    <tr>
        <th>Ід</th>
        <th>Категорія</th>
        <th>Ключі</th>
        <th>Іконка</th>
        <th>Активна</th>
        <th>Дата</th>
        <th>Дія</th>
    </tr>
@endsection
@section("tbody")
    @foreach($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td><button data-content="{{ $category->keywords }}" data-bs-toggle="modal" data-bs-target="#keywordsModal" class="btn btn-outline-dark btn-edit-category-keywords"><i class="fa-solid fa-key"></i> Ключі</button></td>
            <td><button data-src="{{ asset("storage") . "/icons/" . $category->image }}" class="btn btn-outline-dark btn-icon" data-bs-toggle="modal" data-bs-target="#iconModal"><i class="fa-solid fa-ice-cream"></i> Іконка</button></td>
            <td>
                <select data-url="{{ route("admin_categories.change_category_status") }}" class="form-select category-active" name="active">
                    <option value="1">Так</option>
                    <option {{ ($category->active == 0) ? "selected" : "" }} value="0">Ні</option>
                </select>
            </td>
            <td>{{ $category->created_at }}</td>
            <td>
                <div class="actions text-center">
                    <i data-url="{{ route("admin_categories.delete_category") }}" class="fa-solid fa-trash"></i>
                </div>
            </td>
        </tr>
    @endforeach
@endsection

@section("content-continue")
    <!-- Modal -->
    <div class="modal fade" id="iconModal" tabindex="-1" aria-labelledby="iconModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="iconModalLabel"><i class="fa-solid fa-ice-cream"></i> Іконка категорії</h5>
                    <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">&nbsp;&nbsp;</button>
                </div>
                <div class="modal-body text-center">
                    <div class="loader-img">
                        <img src="" alt="Icon" id="icon-img" class="mb-3">
                    </div>
                    <br>
                    <span class="fw-bold">Вибрати нову іконку:</span>
                    <div class="d-flex justify-content-center">
                        <input data-url="{{ route("admin_categories.update_category_image") }}" placeholder="Фото" type="file" accept="image/*" class="form-control mb-2" id="load-image">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="keywordsModal" tabindex="-1" aria-labelledby="keywordsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route("admin_categories.edit_keywords") }}" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="keywordsModalLabel"><i class="fa-solid fa-edit"></i> Ключові слова</h5>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">&nbsp;&nbsp;</button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input id="id-category-keywords-hidden" value="" type="hidden" name="id">
                        <textarea placeholder="Перечисліть ключі через кому..." class="form-control" name="keywords" id="textarea-keywords" cols="30" rows="10"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn-save-keywords" class="btn btn-dark">Зберегти</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

