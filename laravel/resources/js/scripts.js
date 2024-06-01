/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    //
// Scripts
//

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
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
                let productsSelect = "";
                let urlProduct = $(".modal-body").attr("data-product-url");
                for (let item of response) {
                    productsSelect += "<div id='p-" + item.id + "' style='height: 120px; background: cornsilk!important;' class='card d-block mb-3'>" +
                        "<img class='float-start d-block me-2' width='150px' height='120px' src='" + item.image +"'>" +
                        "<div class='d-block'><a href='" + urlProduct + "/" + item.id + "' class='mt-1 fw-bold text-decoration-none text-dark d-block'>" + item.name + " " + item.count_substance + "</a>" +
                        "---<span class='d-block fw-bold'><span class='text-warning'>Кількість:</span> " + item.count + " шт</span>" +
                        "<span class='d-block fw-bold'><span class='text-warning'>Ціна:</span> " + item.price + " грн</span></div>" +
                        "</div>";
                }
                $(".modal-body").html(productsSelect);
                $(".modal-body").attr("data-order", idOrder);
            }
        });
    });

    $("#add-category-plus").click(function (event) {
        if ($(".add-category-block").css("display") == "none") {
            $(".add-category-block").css("display", "block");
            $("#add-name-category-input").val("");
            $("#add-image-category-input").val("");
        } else {
            $(".add-category-block").css("display", "none");
        }
    });

    $("#add-product-plus").click(function (event) {
        if ($(".add-product-block").css("display") == "none") {
            $(".add-product-block").css("display", "block");
            $("#add-product-name").val("");
            $("#add-product-description").val("");
            $("#add-product-count").val("");
            $("#add-product-price").val("");
            $("#add-product-image").val("");
        } else {
            $(".add-product-block").css("display", "none");
        }
    });

    $("#add-category-btn").click(function (event) {
        let data = new FormData();
        let category_name = $("#add-name-category-input").val();
        let category_active = $("#isActiveCategory").prop('checked');
        let category_image = $("#add-image-category-input").prop('files')[0];
        let url = $("#add-category-btn").attr("data-url");

        data.append("_token", $('meta[name="csrf-token"]').attr('content'));
        data.append("category_name", category_name);
        data.append("category_active", category_active);
        data.append("category_image", category_image);
        // $(".category-loader").html("<div class='float-end'><div style='height: 15px; width: 15px;' class=\"spinner-border\" role=\"status\">\n" +
        //     "  <span class=\"visually-hidden\">Loading...</span>\n" +
        //     "</div></div>");

        $.ajax({
            type:'POST',
            enctype: 'multipart/form-data',
            url: url,
            processData: false,
            contentType: false,
            data: data,
            success: function (response) {
                $("#add-category-footer").prepend("<div id='c-" + response.id + "' class='card text-white bg-primary p-2 mb-1 pointer'>" + response.name + "</div>");
                $(".category-loader").html("");
                $(".add-category-block").css("display", "none");
            }
        });
    });

    $("#add-product-btn").click(function (event) {
        let data = new FormData();
        let product_name = $("#add-product-name").val();
        let product_description = $("#productDescription").html()
        let product_count = $("#add-product-count").val();
        let product_price = $("#add-product-price").val();
        let product_active = $("#is-active-product").prop('checked');
        let product_category_id = $("#add-product-category").val();
        let arr_images = $("#add-product-image").prop('files');
        let url = $("#add-product-btn").attr("data-url");

        data.append("_token", $('meta[name="csrf-token"]').attr('content'));
        data.append("product_name", product_name);
        data.append("product_description", product_description);
        data.append("product_count", product_count);
        data.append("product_price", product_price);
        data.append("product_active", product_active);
        data.append("product_category_id", product_category_id);
        for (let el of arr_images) {
            data.append("product_images[]", el);
        }
        // $(".product-loader").html("<div class='float-end'><div style='height: 15px; width: 15px;' class=\"spinner-border\" role=\"status\">\n" +
        //     "  <span class=\"visually-hidden\">Loading...</span>\n" +
        //     "</div></div>");

        $.ajax({
            type:'POST',
            enctype: 'multipart/form-data',
            url: url,
            processData: false,
            contentType: false,
            data: data,
            success: function (response) {
                $("#add-product-footer").prepend("<div id='p-" + response.id + "' class='card text-white bg-warning p-2 mb-1 pointer'>" + response.name + "</div>");
                $(".product-loader").html("");
                $(".add-product-block").css("display", "none");
            }
        });
    });

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
});



