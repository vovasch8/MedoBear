window.addEventListener('DOMContentLoaded', event => {
    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }
});

setTimeout(function() {
    $(".preload").css("display", 'none');
    $(".content-body").css("display", 'none');
}, 1200);

$(document).ready(function () {
    $(function() {
        $('.poshtaPopover').popover({
            placement: "right",
            trigger: "click"
        });

        $('.tooltipPromo').tooltip({
            placement: "right",
            trigger: "hover"
        });
    });

// --------------Tables--------------
    var toast = new bootstrap.Toast($(".toast"), []);
    $("#typeTable").val($("#typeTable").attr("data-selected"));

    $('.actions .fa-trash').click(function () {
        let id = $(this).closest("tr").children(":first").text();
        let tr = $(this).closest("tr");
        let url = $(this).attr("data-url");
        $.confirm({
            title: 'Підтвердження',
            content: 'Ви впевнені що хочете видалити цей запис?',
            buttons: {
                confirm: {
                    text: 'Так',
                    btnClass: 'btn-dark',
                    action: function () {
                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id": id},
                            success: function (response) {
                                $(tr).remove();
                            }
                        });
                    }
                },
                cancel: {
                    text: 'Закрити',
                    btnClass: 'btn-dark',
                    action: function () {

                    }
                }
            }
        });
    });

    $(".btn-order-products").click(function (event) {
        $(".modal-body").html("<div class='d-flex justify-content-center w-100'><div class=\"spinner-border p-5\" role=\"status\">\n" +
            "  <span class=\"visually-hidden\">Loading...</span>\n" +
            "</div></div>");
        let url = $(this).attr("data-url");
        let orderItem = $(this).closest('tr');
        let idOrder = $(orderItem).children().first().text();

        $.ajax({
            type: 'POST',
            url: url,
            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id_order": idOrder},
            success: function (response) {
                $(".modal-body").html(response);
                $(".modal-body").attr("data-order", idOrder);
            }
        });
    });

    $("#addProductsBtnToOrder").click(function (event) {
        let url = $(this).attr("data-url");
        let idOrder = $(".modal-body").attr("data-order");
        let idProduct = $("#idProductOrderAdd").val();
        let count = $("#countProductOrder").val();

        $.ajax({
            type: 'POST',
            url: url,
            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id_order": idOrder, "id_product": idProduct, "count": count},
            success: function (response) {
                let productsSelect = "";
                let urlProduct = $(".modal-body").attr("data-product-url");
                for (let item of response) {
                    if ($("#p-" + item.id).length) {
                        $("#p-" + item.id).remove();
                    }
                    productsSelect += "<div id='p-" + item.id + "' style='height: 120px; background: cornsilk!important;' class='card d-block mb-3'>" +
                        "<img class='float-start d-block me-2' width='150px' height='120px' src='" + item.image +"'>" +
                        "<div class='d-block'><a href='" + urlProduct + "/" + item.id + "' class='mt-1 fw-bold text-decoration-none text-dark d-block'>" + item.name + " " + item.count_substance + "</a>" +
                        "---<span class='d-block fw-bold'><span class='text-warning'>Кількість:</span> " + item.count + " шт</span>" +
                        "<span class='d-block fw-bold'><span class='text-warning'>Ціна:</span> " + item.price + " грн</span></div>" +
                        "</div>";
                }
                $(".modal-body").prepend(productsSelect);
                $("#idProductOrderAdd").val("");
                $("#countProductOrder").val("");
            }
        });
    });

    $("#edit-order-btn").click(function (event) {
        $("#edit-order-block").css("display", "block");
    });

    $("#closeEditBlock").click(function (event) {
        $("#edit-order-block").css("display", "none");
        $("#idProductOrderAdd").val("");
        $("#countProductOrder").val("");
        $("#idProductOrderDelete").val("");
    });

    $("tbody td").click(function (event) {
        if (event.target != document.querySelector("#edit-input") && $("#edit-form").css("display") == "none") {
            let editedColumns = JSON.parse($("table").attr("data-edited-column"));

            if (editedColumns.includes($(this).index())) {
                $("#old-text").text($.trim($(this).text()));
                $(this).html($("#edit-form"));
                $("#edit-input").val($.trim($(this).text()));
                $("#edit-form").css("display", "flex");
                $("#edit-input").focus();
            }
        }
    });

    $("#edit-input").on("keypress", function (event) {
        if (event.keyCode === 13) {
            let oldText = $("#old-text").text();
            let text = $("#edit-input").val();
            let td = $(this).closest("td");
            $(".edit-block").html($("#edit-form"));
            if (oldText === text) {
                $(td).text(oldText);
                $("#edit-form").css("display", "none");
            } else {
                let url = $("#edit-input").attr("data-url");
                let id = $(td).closest("tr").children(":first").text();
                let column = $(td).index();
                let value = text;
                let table = $("#typeTable").attr("data-selected");
                $("#edit-form").css("display", "none");

                $(td).html("<div class='w-100 text-center'><div class=\"spinner-grow text-dark\" role=\"status\"><span class=\"visually-hidden\">Loading...</span></div></div>");
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "table": table,
                        "id": id,
                        "column": column,
                        "value": value
                    },
                    success: function (response) {
                        td.html(response);
                    }, error: function (error) {
                        console.log("error");
                        toast.show();
                        $(td).html(oldText);
                    }
                });
            }
        }
    });

    $(".category-active").on( "change", function () {
        let url = $(this).attr("data-url");
        let id = $(this).closest("tr").children(":first").text();
        let value = $(this).val();

        $.ajax({
            type: 'POST',
            url: url,
            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id": id, "value": value},
            success: function (response) {

            }
        });
    });

    $(".product-active").on( "change", function () {
        let url = $(this).attr("data-url");
        let id = $(this).closest("tr").children(":first").text();
        let value = $(this).val();

        $.ajax({
            type: 'POST',
            url: url,
            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id": id, "value": value},
            success: function (response) {

            }
        });
    });

    $(".product-category").on( "change", function () {
        let url = $(this).attr("data-url");
        let id = $(this).closest("tr").children(":first").text();
        let value = $(this).val();

        $.ajax({
            type: 'POST',
            url: url,
            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id": id, "value": value},
            success: function (response) {

            }
        });
    });

    $(".user-role").on( "change", function () {
        let url = $(this).attr("data-url");
        let id = $(this).closest("tr").children(":first").text();
        let value = $(this).val();

        $.ajax({
            type: 'POST',
            url: url,
            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id": id, "value": value},
            success: function (response) {

            }
        });
    });

    $(".btn-icon").click(function () {
        let src = $(this).attr("data-src");
        let id = $(this).closest("tr").children(":first").text();
        $("#icon-img").attr("src", src);
        $("#icon-img").attr("data-id", id);
    });

    $("#load-image").on("change", function () {
        let data = new FormData();
        let id = $("#icon-img").attr("data-id");
        let src = $("#icon-img").attr("src");
        let category_image = $("#load-image").prop('files')[0];
        let url = $(this).attr("data-url");

        data.append("_token", $('meta[name="csrf-token"]').attr('content'));
        data.append("category_image", category_image);
        data.append("id", id);
        $(".loader-img").html("<div class='d-flex justify-content-center'><div style='height: 100px; width: 100px;' class=\"spinner-border\" role=\"status\">\n" +
            "  <span class=\"visually-hidden\">Loading...</span>\n" +
            "</div></div>");

        $.ajax({
            type:'POST',
            enctype: 'multipart/form-data',
            url: url,
            processData: false,
            contentType: false,
            data: data,
            success: function (response) {
                $(".loader-img").html("<img data-id='" + id + "' src=\"" + response + "\" alt=\"Icon\" id=\"icon-img\" class=\"mb-3\">");
                $("#load-image").val("");
                $("[data-src='" + src + "']").attr("data-src", response);
            }
        });
    });

    $(".btn-edit-description").click(function () {
        let content = $(this).attr("data-content");
        let id = $(this).closest("tr").children(":first").text();
        $(".trix-editor-description").html(content);
        $("#id-product-hidden").val(id);
    });

    $(".btn-edit-keywords").click(function () {
        let content = $(this).attr("data-content");
        let id = $(this).closest("tr").children(":first").text();
        $("#textarea-keywords").val(content);
        $("#id-product-keywords-hidden").val(id);
    });

    $(".btn-product-images").click(function () {
        let imageUrls = $(this).attr("data-images");
        let clickedBufferedId = $(this).attr("data-click");
        $("#productModal").attr("data-entity", clickedBufferedId);

        let id = $(this).closest("tr").children(":first").text();
        imageUrls = JSON.parse(imageUrls);
        let data = generateAlbumPhotos(id, imageUrls);

        initFotorama(data);
    });

    $(".tool-arrow").click(function () {
        let productId = $("#productModal").attr("data-entity");
        let images = getArrayImages();
        let activeImage = getActiveImage();
        let url = $(this).attr("data-url");
        let direction = $(this).attr("data-direction");
        let fatherId = null;
        let childId = null;
        let thisId = null;

        for (let i = 0; i < images.length; i++) {
            if (images[i]['image'] === activeImage) {
                if (direction === "left" && i !== 0) {
                    let thisImage = images[i];
                    thisId = thisImage['id'];
                    fatherId = images.find((element) => element.id == thisImage['father_id']).id;
                    childId = (i < images.length - 2) ? images.find((element) => element.father_id == thisId).id : null;
                } else if (direction === "right" && i !== images.length - 1) {
                    let fatherImage = images[i];
                    fatherId = fatherImage['id'];
                    thisId = images.find((element) => element.father_id == fatherImage['id']).id;
                    childId = (i < images.length - 2) ? images.find((element) => element.father_id == thisId).id : null;
                } else {
                    return false;
                }

                $(".photos").html("<div class='d-flex justify-content-center w-100 pt-5 pb-5'><div class=\"spinner-border p-5\" role=\"status\">\n" +
                    "  <span class=\"visually-hidden\">Loading...</span>\n" +
                    "</div></div>");
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "this_id": thisId,
                        "right_id": childId,
                        "left_id": fatherId,
                        "product_id": productId
                    },
                    success: function (product) {
                        let jsonUrls = JSON.stringify(product.images);
                        $('[data-click="' + product.id + '"]').attr("data-images", jsonUrls);

                        let data = generateAlbumPhotos(product.id, product.images);
                        initFotorama(data);
                    }
                });
            }
        }
    });

    $("#load-files").on("change", function () {
        let url = $("#tool-add").attr("data-url");
        let productId = $("#productModal").attr("data-entity");
        let data = new FormData();
        let files = $("#load-files").prop('files');

        if (files.length) {
            data.append("_token", $('meta[name="csrf-token"]').attr('content'));
            data.append("product_id", productId);
            for (let el of files) {
                data.append("product_images[]", el);
            }

            $(".photos").html("<div class='d-flex justify-content-center w-100 pt-5 pb-5'><div class=\"spinner-border p-5\" role=\"status\">\n" +
                "  <span class=\"visually-hidden\">Loading...</span>\n" +
                "</div></div>");
            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: url,
                processData: false,
                contentType: false,
                data: data,
                success: function (product) {
                    let jsonUrls = JSON.stringify(product.images);
                    $('[data-click="' + product.id + '"]').attr("data-images", jsonUrls);

                    let data = generateAlbumPhotos(product.id, product.images);
                    initFotorama(data);
                }
            });
        }
    });

    $("#tool-remove").click(function () {
        let url = $(this).attr("data-url");
        let productId = $("#productModal").attr("data-entity");
        let activeImage = getActiveImage();
        let images = getArrayImages();

        for (let i = 0; i < images.length; i++) {
            if (images[i]['image'] === activeImage) {
                let thisImageId = images[i]['id'];
                let fatherId = (images[i]['father_id'] !== 0) ? images.find((element) => element.id == images[i]['father_id']).id : null;
                let childId = (i < images.length - 1) ? images.find((element) => element.father_id == thisImageId).id : null;

                $(".photos").html("<div class='d-flex justify-content-center w-100 pt-5 pb-5'><div class=\"spinner-border p-5\" role=\"status\">\n" +
                    "  <span class=\"visually-hidden\">Loading...</span>\n" +
                    "</div></div>");
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "this_id": thisImageId,
                        "right_id": childId,
                        "left_id": fatherId,
                        "product_id": productId
                    },
                    success: function (product) {
                        let jsonUrls = JSON.stringify(product.images);
                        $('[data-click="' + product.id + '"]').attr("data-images", jsonUrls);

                        let data = generateAlbumPhotos(product.id, product.images);
                        initFotorama(data);
                    }
                });
            }
        }
    });

    $(".btn-add-promo").click(function () {
        let promocode = $("#promocode").val();
        let discount = $("#discount").val();
        let end_date = $("#endDate").val();
        let url = $(this).attr("data-url");
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "promocode": promocode,
                "discount" : discount,
                "end_date" : end_date
            },
            success: function (promocode) {
                location.reload(true);
            }
        });
    });

    $('.promos .fa-trash').click(function () {
        let id = $(this).closest("tr").children(":first").text();
        let tr = $(this).closest("tr");
        let url = $(this).attr("data-url");
        $.confirm({
            title: 'Підтвердження',
            content: 'Ви впевнені що хочете видалити цей запис?',
            buttons: {
                confirm: {
                    text: 'Так',
                    btnClass: 'btn-dark',
                    action: function () {
                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id": id},
                            success: function (response) {
                                $(tr).remove();
                            }
                        });
                    }
                },
                cancel: {
                    text: 'Закрити',
                    btnClass: 'btn-dark',
                    action: function () {

                    }
                }
            }
        });
    });

    $(".btn-pay").click(function (event) {
        let url = $(this).attr("data-url");
        let userItem = $(this).closest('tr');
        let idUser = $(userItem).children().first().text();

        $.ajax({
            type: 'POST',
            url: url,
            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id_partner": idUser},
            success: function (response) {
                location.reload();
            }
        });
    });

    function initFotorama(data) {
        $(".photos").html("<div id=\"fotorama\" data-auto=\"false\" class=\"fotorama bg-light\" data-width=\"100%\" data-ratio=\"800/600\" data-allowfullscreen=\"true\"  data-loop=\"true\"></div>");
        // $("#fotorama").html(imagesHtml);
        $('.fotorama').fotorama({
            data: data
        });
    }

    function generateAlbumPhotos(id, imageUrls) {
        let path = $(".photos").attr("data-full-path");

        let data = [];
        for (let i = 0; i < imageUrls.length; i++) {
            data.push({img: path + "/products/" + id + "/" + imageUrls[i]['image'], id: id});
        }

        return data;
    }

    function getActiveImage() {
        let activeImage = $(".fotorama__active img").attr("src");
        if (activeImage) {
            return  activeImage.substring(activeImage.lastIndexOf("/") + 1);
        }
    }

    function getArrayImages() {
        let entity = $("#productModal").attr("data-entity");
        let images = $("[data-click='" + entity + "']").attr("data-images");

        return JSON.parse(images);
    }
});
