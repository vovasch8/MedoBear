$(document).ready(function () {

    // ---------------Catalog------------------------
    $('.btn-cart').click(function (event) {
        event.stopPropagation();
    });

    // ----------------Cart----------------------------------
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
    // ----------------Poshta--------------------------------------------

    $(".poshta-block .btn").click(function(event){
        if ($(this).attr('id') == "ukrPoshtaLabel") {
            $(".nova-poshta-block").css("display", "none");
            $(".ukr-poshta-block").css("display", "block");
            $(this).attr("checked", "checked");
            $("#novaPoshta").removeAttr("checked");
            clearPoshtaBlock();
        } else {
            $(".ukr-poshta-block").css("display", "none");
            $(".nova-poshta-block").css("display", "block");
            $(this).attr("checked", "checked");
            $("#ukrPoshta").removeAttr("checked");
        }
    });

    $("#searchCities").keyup(function (event) {
        event.preventDefault();
        let city = $("#searchCities").val();
        let url = $("#searchCities").attr("data-url");
        let dropdownEl = new bootstrap.Dropdown(document.getElementById("cityDrop"));

        if (city.length > 2) {
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
                    $(".cities-select").html(select.length ? select : "<li ><a class=\"dropdown-item disabled\" href=\"#\">Невірний населений пункт!</a></li>");
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
                    $(".warehouses-select").html(select.length ? select : "<li ><a class=\"dropdown-item disabled\" href=\"#\">Невірні дані!</a></li>");
                    dropdownEl.show();
                    $("#searchWarehouses").focus();
                }
            });
        } else {
            dropdownEl.hide();
            $("#searchWarehouses").focus();
            $(".warehouses-select").html("<li ><a class=\"dropdown-item disabled\" href=\"#\">Введіть № відділення/поштомату або вулицю!</a></li>");
        }
    });

    $(".novaRadios").change(function (el) {
        if ($("#novaCourier").prop('checked')) {
            $("#courier-nova-poshta").css("display", "block");
            $("#cities").css("display", "none");
            $("#warehouses").css("display", "none");
        } else {
            $("#courier-nova-poshta").css("display", "none");
            $("#cities").css("display", "flex");
            if ($('#cities input').prop("disabled")) {
                $("#warehouses").css("display", "flex");
            }
        }
    });

    $(".ukrRadios").change(function (el) {
        if ($("#ukrCourier").prop('checked')) {
            $("#courier-ukr-poshta").css("display", "block");
            $("#ukrCities").css("display", "none");
            $("#postOffices").css("display", "none");
        } else {
            $("#courier-ukr-poshta").css("display", "none");
            $("#ukrCities").css("display", "flex");
            if ($('#ukrCities input').prop("disabled")) {
                $("#postOffices").css("display", "flex");
            }
        }
    });

    $("#searchUkrPoshtaCities").keyup(function (event) {
        event.preventDefault();
        let city = $("#searchUkrPoshtaCities").val();
        let url = $("#searchUkrPoshtaCities").attr("data-url");
        let dropdownEl = new bootstrap.Dropdown(document.getElementById("ukrPoshtaCityDrop"));

        if (city.length > 2) {
            $.ajax({
                type: 'POST',
                url: url,
                data: {"_token": $('meta[name="csrf-token"]').attr('content'), "city": city},
                success: function (response) {
                    let select = "";
                    for (let i = 0; i < response.length; i++) {
                        select += "<li><a " +
                            "onclick='let search = document.getElementById(`searchUkrPoshtaCities`); search.setAttribute(`disabled`, ``);" +
                            "search.value = this.textContent; search.setAttribute(`data-cityId`, this.getAttribute(`data-cityId`)); search.setAttribute(`data-districtId`, this.getAttribute(`data-districtId`)); search.setAttribute(`data-regionId`, this.getAttribute(`data-regionId`));" +
                            "document.querySelector(`.ukr-poshta-cities-select`).style.display = `none`; document.getElementById(`postOffices`).style.display = `flex`; '" +
                            "class=\"dropdown-item city-li\" data-cityId=\""+ response[i].CITY_ID + "\" data-districtId=\""+ response[i].DISTRICT_ID+ "\" data-regionId=\""+ response[i].REGION_ID + "\" href=\"#\">"
                            + response[i].SHORTCITYTYPE_UA
                            + " "
                            + response[i].CITY_UA
                            + " "
                            + response[i].DISTRICT_UA
                            + " р. "
                            + response[i].REGION_UA
                            + " обл."
                            + "</a></li>";
                    }
                    $(".ukr-poshta-cities-select").html(select.length ? select : "<li ><a class=\"dropdown-item disabled\" href=\"#\">Невірний населений пункт!</a></li>");
                    dropdownEl.show();
                    $("#searchUkrPoshtaCities").focus();
                }
            });
        } else {
            dropdownEl.hide();
            $("#searchUkrPoshtaCities").focus();
            $(".ukr-poshta-cities-select").html("<li ><a class=\"dropdown-item disabled\" href=\"#\">Введіть населений пункт!</a></li>");
        }
    });

    $("#searchPostOffices").keyup(function (event) {
        event.preventDefault();
        let zipCode = $("#searchPostOffices").val();
        let url = $("#searchPostOffices").attr("data-url");
        let dropdownEl = new bootstrap.Dropdown(document.getElementById("postOfficesDrop"));
        let cityId = $("#searchUkrPoshtaCities").attr("data-cityId");
        let districtId = $("#searchUkrPoshtaCities").attr("data-districtId");
        let regionId = $("#searchUkrPoshtaCities").attr("data-regionId");

        if (zipCode.length) {
            $.ajax({
                type: 'POST',
                url: url,
                data: {"_token": $('meta[name="csrf-token"]').attr('content'), "cityId": cityId, "districtId": districtId, "regionId": regionId, "zipCode": zipCode},
                success: function (response) {
                    let select = "";
                    for (let i = 0; i < response.length; i++) {
                        select += "<li><a " +
                            "onclick='let search = document.getElementById(`searchPostOffices`); search.setAttribute(`disabled`, ``);" +
                            "search.value = this.textContent; document.querySelector(`.post-offices-select`).style.display = `none`;' " +
                            " class=\"dropdown-item\" href=\"#\">" + response[i].POSTCODE + ", " + response[i].CITY_UA + (response[i].STREET_UA_VPZ !== null ? ", " + response[i].STREET_UA_VPZ : "")
                            + "</a></li>";
                    }
                    $(".post-offices-select").html(select.length ? select : "<li ><a class=\"dropdown-item disabled\" href=\"#\">Невірні дані!</a></li>");
                    dropdownEl.show();
                    $("#searchPostOffices").focus();
                }
            });
        } else {
            dropdownEl.hide();
            $("#searchPostOffices").focus();
            $(".post-offices-select").html("<li ><a class=\"dropdown-item disabled\" href=\"#\">Введіть індекс відділення!</a></li>");
        }
    });
});
