@extends("layouts.admin-table")

@section("pre-head")
{{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>--}}
    <link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
@endsection

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
    </tr>
@endsection
@section("tbody")
    @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->description }}</td>
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
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal"><i class="fa-solid fa-circle-xmark"></i> Закрити</button>--}}
{{--                    <button type="button" class="btn btn-outline-dark"><i class="fa-solid fa-square-pen"></i> Зберегти</button>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
@endsection

