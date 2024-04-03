@extends("layouts.admin-table")

@section("thead")
    <tr>
        <th>Ід</th>
        <th>Назва</th>
        <th>Опис</th>
        <th>Кількість</th>
        <th>Ціна</th>
        <th>Фото</th>
        <th>Категорія</th>
        <th>Активний</th>
        <th>Дата створення</th>
        <th>Дія</th>
    </tr>
@endsection
@section("tbody")
    @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td><button data-content="{{ $product->description }}" data-bs-toggle="modal" data-bs-target="#descriptionModal" class="btn btn-outline-dark btn-edit-description"><i class="fa-solid fa-pen-to-square"></i> Опис</button></td>
            <td>{{ $product->count }}</td>
            <td>{{ $product->price }}</td>
            <td><button data-click="{{ $product->id }}" data-images="{{ json_encode($product->images) }}" data-bs-toggle="modal" data-bs-target="#productModal" class="btn btn-outline-dark btn-product-images"><i class="fa-solid fa-image"></i> Фото</button></td>
            <td>
                <select data-url="{{ route("admin_products.change_product_category") }}" class="form-select product-category" name="category">
                    @foreach($categories as $category)
                        <option {{ ($product->category_id == $category->id) ? "selected" : "" }} value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select data-url="{{ route("admin_products.change_product_status") }}" class="form-select product-active" name="active">
                    <option value="1">Так</option>
                    <option {{ ($product->active == 0) ? "selected" : "" }} value="0">Ні</option>
                </select>
            </td>
            <td>{{ $product->created_at }}</td>
            <td><div class="actions text-center"><i data-url="{{ route("admin_products.delete_product") }}" class="fa-solid fa-trash"></i></div></td>
        </tr>
    @endforeach
@endsection

@section("content-continue")
    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="toolbar w-100">
                        <div class="inner bg-dark d-flex mb-2 justify-content-between fs-5 p-2">
                            <span class="fw-bold text-white">Дії:&nbsp;</span>
                            <div class="order-photos">
                                <button data-direction="left" data-url="{{ route("admin_products.move_photo_product") }}" class="btn btn-warning btn-sm btn-move tool-arrow"><i class="fa-solid fa-circle-arrow-left"></i></button>
                                <span class="fw-bold fs-6 text-white">Перемістити</span>
                                <button data-direction="right" data-url="{{ route("admin_products.move_photo_product") }}" class="btn btn-warning btn-sm btn-move tool-arrow"><i class="fa-solid fa-circle-arrow-right"></i></button>
                            </div>
                            <div class="toolbar-actions">
                                <button data-url="{{ route("admin_products.remove_photo_product") }}" id="tool-remove" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                <button data-url="{{ route("admin_products.add_photo_product") }}" id="tool-add" class="btn btn-warning pointer">
                                    <label class="pointer" for="load-files">
                                        <i class="fa-solid fa-circle-plus"></i>
                                    </label>
                                </button>
                                <input id="load-files" class="d-none" type="file" multiple accept="image/*">
                                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-circle-xmark"></i></button>
                            </div>
                        </div>
                    </div>
                    <div data-full-path="{{ asset('storage') }}" class="photos d-block">
                        <div id="fotorama" data-auto="false" class="fotorama bg-light" data-width="100%" data-ratio="800/600" data-allowfullscreen="true"  data-loop="true"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="descriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route("admin_products.edit_description") }}" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="descriptionModalLabel"><i class="fa-solid fa-edit"></i> Опис</h5>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">&nbsp;&nbsp;</button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input id="id-product-hidden" value="" type="hidden" name="id">
                        <input id="modal-description" value="" type="hidden" name="content">
                        <trix-editor class="trix-editor-description" input="modal-description"></trix-editor>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn-save-description" class="btn btn-dark">Зберегти</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

