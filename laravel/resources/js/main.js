$(document).ready(function () {

    $('.btn-cart').click(function (event) {
        event.stopPropagation();
    });

    $(".btn-delete").click(function (event) {
        let element = $(this);
        let idProduct = $(this).attr('id');
        let url = $(element).attr("data-url");
        idProduct = idProduct.substr(8);

        $.ajax({
            type: 'POST',
            url: url,
            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id_product": idProduct},
            success: function (response) {
                let data = jQuery.parseJSON(response);
                $("#productCounter").text(data.count);
                $(element).closest("tr").remove();
                $("#totalPrice").text(data.totalPrice + " грн");
            }
        });
    });

    $("#btn-promocode").click(function (event) {
        let promocode = $('#promocodeInput').val();
        let url = $(this).attr("data-url");

        if (promocode.length) {
            $.ajax({
                type: 'POST',
                url: url,
                data: {"_token": $('meta[name="csrf-token"]').attr('content'), "promocode": promocode},
                success: function (response) {
                    if (typeof response['error'] !== "undefined") {
                        $(".error").text(response['error']);
                        $("#promocodeInput").css('border-color', 'red');
                    } else {
                        $("#totalPrice").text(response + " грн");
                        $("#promocodeInput").attr('disabled', 'disabled');
                        $("#promocodeInput").css('border-color', 'lightgrey');
                        $("#btn-promocode").attr("onclick", "");
                        $(".error").text("");
                    }
                }
            });
        }
    });

    $("#searchCities").keyup(function (event) {
        event.preventDefault();
        let city = $("#searchCities").val();
        let url = $("#searchCities").attr("data-url");
        let dropdownEl = new bootstrap.Dropdown(document.getElementById("cityDrop"));

        if (city.length) {
            $.ajax({
                type: 'POST',
                url: url,
                data: {"_token": $('meta[name="csrf-token"]').attr('content'), "city": city},
                success: function (response) {
                    let data = response['data'][0]['Addresses']
                    let select = "";
                    for (let i = 0; i < data.length; i++) {
                        select += "<li><a " +
                            "onclick='let search = document.getElementById(`searchCities`); search.setAttribute(`disabled`, ``);" +
                            "search.value = this.textContent; search.setAttribute(`data-cityref`, this.id); search.setAttribute(`data-city`, this.getAttribute(`data-city`)); " +
                            "document.querySelector(`.cities-select`).style.display = `none`; document.getElementById(`warehouses`).style.display = `flex`; '" +
                            "id='" + data[i]["DeliveryCity"] + "' class=\"dropdown-item city-li\" data-city=\""+ data[i]["MainDescription"] +"\" href=\"#\">" + data[i]["Present"]
                            + "</a></li>";
                    }
                    $(".cities-select").html(select);
                    dropdownEl.show();
                    $("#searchCities").focus();
                }
            });
        } else {
            dropdownEl.hide();
            $("#searchCities").focus();
            $(".cities-select").html("<li ><a class=\"dropdown-item disabled\" href=\"#\">Введіть населений пункт!</a></li>");
        }
    });

    $("#searchWarehouses").keyup(function (event) {
        event.preventDefault();
        let warehouse = $("#searchWarehouses").val();
        let url = $("#searchWarehouses").attr("data-url");
        let dropdownEl = new bootstrap.Dropdown(document.getElementById("warehousesDrop"));
        let city = $("#searchCities").attr("data-city");
        let cityRef = $("#searchCities").attr("data-cityref");

        if (warehouse.length) {
            $.ajax({
                type: 'POST',
                url: url,
                data: {"_token": $('meta[name="csrf-token"]').attr('content'), "city": city, "cityRef": cityRef, "warehouse": warehouse},
                success: function (response) {
                    let data = response["data"];
                    let select = "";
                    for (let i = 0; i < data.length; i++) {
                        select += "<li><a " +
                            "onclick='let search = document.getElementById(`searchWarehouses`); search.setAttribute(`disabled`, ``);" +
                            "search.value = this.textContent; document.querySelector(`.warehouses-select`).style.display = `none`;' " +
                            " class=\"dropdown-item\" href=\"#\">" + data[i]["Description"]
                            + "</a></li>";
                    }
                    $(".warehouses-select").html(select);
                    dropdownEl.show();
                    $("#searchWarehouses").focus();
                }
            });
        } else {
            dropdownEl.hide();
            $("#searchWarehouses").focus();
            $(".warehouses-select").html("<li ><a class=\"dropdown-item disabled\" href=\"#\">Введіть відділення чи вулицю!</a></li>");
        }
    });
});
