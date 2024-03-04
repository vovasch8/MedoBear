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


$(document).ready(function () {
// --------------Tables--------------
    $("#typeTable").val($("#typeTable").attr("data-selected"));

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

    $("#removeProductBtnFromOrder").click(function (event) {
        let url = $(this).attr("data-url");
        let idOrder = $(".modal-body").attr("data-order");
        let idProduct = $("#idProductOrderDelete").val();

        $.ajax({
            type: 'POST',
            url: url,
            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id_order": idOrder, "id_product": idProduct},
            success: function (response) {
                $("#p-" + response).remove();
                $("#idProductOrderDelete").val("");
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
        let editedColumns = JSON.parse($("table").attr("data-edited-column"));

        if (editedColumns.includes($(this).index())) {
            $("#old-text").text($.trim($(this).text()));
            $(this).html($("#edit-form"));
            $("#edit-input").val($.trim($(this).text()));
            $("#edit-form").css("display", "flex");
            $("#edit-input").focus();
        }
    });

    $("#edit-input").on("focusout", function (event) {
        let oldText = $("#old-text").text();
        let text = $("#edit-input").val();
        console.log(text);
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
                data: {"_token": $('meta[name="csrf-token"]').attr('content'), "table": table, "id": id, "column": column, "value": value},
                success: function (response) {
                    td.html(response);
                }
            });
        }
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
