
$(document).ready(function () {
// --------------Tables--------------
    $("tbody td").click(function (event) {
        if ([1, 2, 5].includes($(this).index())) {
            $("#old-text").text($.trim($(this).text()));
            $(this).html($("#edit-form"));
            $("#edit-input").val($.trim($(this).text()));
            $("#edit-form").css("display", "flex");
            $("#edit-input").focus();
        }
    });

    $("#edit-input").on("focusout", function (event) {
        let text = $("#old-text").text();
        let td = $(this).closest("td");
        $(".edit-block").html($("#edit-form"));
        td.text(text);
        $("#edit-form").css("display", "none");
    });

    $("#edit-order-btn").click(function (event) {
        $("#edit-order-block").css("display", "block");
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
});
