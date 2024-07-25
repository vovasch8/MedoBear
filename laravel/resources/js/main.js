$(document).ready(function () {

    // ---------------Catalog------------------------
    $('.btn-add-product').click(function (event) {
        event.preventDefault();
        let url = $(this).attr("data-url");
        let idProduct = $(this).closest('.card').attr('id');
        let count = $(this).closest('.btn-block').find('.product-price').attr('data-count');
        idProduct = idProduct.substr(2);

        $(this).find(".fa-check-circle").removeClass("d-none");
        $(this).find(".fa-shopping-basket").addClass("d-none");
        $.ajax({
            type:'POST',
            url: url,
            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id_product" : idProduct, "count_value": count},
            success: function (response) {
                $("#productCounter").css("display", "inline-block")
                $("#productCounter").text(response);
            }
        });
        setTimeout(() => {
            $(this).find(".fa-shopping-basket").removeClass("d-none");
            $(this).find(".fa-check-circle").addClass("d-none");
        }, "1500");
    });

    $('.count-value').click(function (event) {
        event.preventDefault();
        let price = $(this).attr('data-price');
        let oldActiveEl = $(this).parent().find('.btn-warning');
        oldActiveEl.removeClass('btn-warning');
        oldActiveEl.addClass('btn-outline-warning');
        $(this).removeClass('btn-outline-warning');
        $(this).addClass('btn-warning');
        $(this).parent().parent().find('.product-price').text(price);
        $(this).parent().parent().find('.product-price').attr("data-count", $(this).attr("data-count"));
        let url = $(this).closest('.product').attr("href");
        let pos = url.lastIndexOf('/');
        url = url.substring(0, pos) + '/' + $(this).attr("data-count");
        $(this).closest('.product').attr("href", url);
    });

    // ----------------Cart----------------------------------
    $(".btn-delete").click(function (event) {
        let element = $(this);
        let idProduct = $(this).attr('id');
        let url = $(element).attr("data-url");
        let size = $(this).attr("data-size");
        idProduct = idProduct.substr(8);

        $.ajax({
            type: 'POST',
            url: url,
            data: {"_token": $('meta[name="csrf-token"]').attr('content'), "id_product": idProduct, "count_value": size},
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
                    $(".cities-select").css("display", "block");
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

    $("#searchCourierCities").keyup(function (event) {
        event.preventDefault();
        let city = $("#searchCourierCities").val();
        let url = $("#searchCourierCities").attr("data-url");
        let dropdownEl = new bootstrap.Dropdown(document.getElementById("cityCourierDrop"));

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
                            "onclick='let search = document.getElementById(`searchCourierCities`); search.setAttribute(`disabled`, ``);" +
                            "search.value = this.textContent;" +
                            "document.querySelector(`.cities-courier-select`).style.display = `none`; '" +
                            "class=\"dropdown-item city-li\" href=\"#\">" + data[i]["Present"]
                            + "</a></li>";
                    }
                    $(".cities-courier-select").html(select.length ? select : "<li ><a class=\"dropdown-item disabled\" href=\"#\">Невірний населений пункт!</a></li>");
                    $(".cities-courier-select").css("display", "block");
                    dropdownEl.show();
                    $("#searchCourierCities").focus();
                }
            });
        } else {
            dropdownEl.hide();
            $("#searchCourierCities").focus();
            $(".cities-courier-select").html("<li ><a class=\"dropdown-item disabled\" href=\"#\">Введіть населений пункт!</a></li>");
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
                    $(".warehouses-select").css("display", "block");
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
                    $(".ukr-poshta-cities-select").css("display", "block");
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

    $("#searchUkrPoshtaCourierCities").keyup(function (event) {
        event.preventDefault();
        let city = $("#searchUkrPoshtaCourierCities").val();
        let url = $("#searchUkrPoshtaCourierCities").attr("data-url");
        let dropdownEl = new bootstrap.Dropdown(document.getElementById("ukrPoshtaCourierCityDrop"));

        if (city.length > 2) {
            $.ajax({
                type: 'POST',
                url: url,
                data: {"_token": $('meta[name="csrf-token"]').attr('content'), "city": city},
                success: function (response) {
                    let select = "";
                    for (let i = 0; i < response.length; i++) {
                        select += "<li><a " +
                            "onclick='let search = document.getElementById(`searchUkrPoshtaCourierCities`); search.setAttribute(`disabled`, ``);" +
                            "search.value = this.textContent;" +
                            "document.querySelector(`.ukr-poshta-courier-cities-select`).style.display = `none`; '" +
                            "class=\"dropdown-item city-li\" href=\"#\">"
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
                    $(".ukr-poshta-courier-cities-select").html(select.length ? select : "<li ><a class=\"dropdown-item disabled\" href=\"#\">Невірний населений пункт!</a></li>");
                    $(".ukr-poshta-courier-cities-select").css("display", "block");
                    dropdownEl.show();
                    $("#searchUkrPoshtaCourierCities").focus();
                }
            });
        } else {
            dropdownEl.hide();
            $("#searchUkrPoshtaCourierCities").focus();
            $(".ukr-poshta-courier-cities-select").html("<li ><a class=\"dropdown-item disabled\" href=\"#\">Введіть населений пункт!</a></li>");
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
                    $(".post-offices-select").css("display", "block");
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

    // ----------Create Order-------------------------------
    $("#btn-order").click(function () {
        let url = $("#btn-order").attr("data-url");
        let errors = [];
        let pip = $("[name='pip']").val() ? $("[name='pip']").val() : errors.push("*Заповніть поле Повного імені!");
        let phone = $("[name='phone']").val() ? $("[name='phone']").val() : errors.push("*Заповніть поле Номер телефону!");
        let poshta = {};
        if ($("#novaPoshta").prop('checked')) {
            poshta.type_poshta = $("#novaPoshta").val();
            if ($("#novaCourier").prop('checked')) {
                poshta.type_delivery = $("#novaCourier").val();
                ($("#searchCourierCities").val() && $("#searchCourierCities").attr("disabled") !== undefined ) ? poshta.nova_city = $("#searchCourierCities").val() : errors.push("*Виберіть населений пункт!");
                $("[name='nova_street']").val() ? poshta.street = $("[name='nova_street']").val() : errors.push("*Заповніть поле Вулиця!");
                $("[name='nova_house']").val() ? poshta.house = $("[name='nova_house']").val() : errors.push("*Заповніть поле Будинок!");
                poshta.room = $("[name='nova_room']").val();
            } else {
                poshta.type_delivery = $("#novaWarehouse").val();
                ($("#searchCities").val() && $("#searchCities").attr("disabled") !== undefined ) ? poshta.nova_city = $("#searchCities").val() : errors.push("*Виберіть населений пункт!");
                ($("#searchWarehouses").val() && $("#searchWarehouses").attr("disabled")) ? poshta.nova_warehouse = $("#searchWarehouses").val() : errors.push("*Виберіть відділення!");
            }
        } else {
            poshta.type_poshta = $("#ukrPoshta").val();
            if ($("#ukrCourier").prop('checked')) {
                poshta.type_delivery = $("#ukrCourier").val();
                ($("#searchUkrPoshtaCourierCities").val() && $("#searchUkrPoshtaCourierCities").attr("disabled") !== undefined) ? poshta.ukr_city = $("#searchUkrPoshtaCourierCities").val() : errors.push("*Виберіть населений пункт!");
                $("[name='ukr_street']").val() ? poshta.street = $("[name='ukr_street']").val() : errors.push("*Заповніть поле Вулиця!");
                $("[name='ukr_house']").val() ? poshta.house = $("[name='ukr_house']").val() : errors.push("*Заповніть поле Будинок!");
                poshta.room = $("[name='ukr_room']").val();
            } else {
                poshta.type_delivery = $("#ukrPostOfiice").val();
                ($("#searchUkrPoshtaCities").val() && $("#searchUkrPoshtaCities").attr("disabled") !== undefined) ? poshta.ukr_city = $("#searchUkrPoshtaCities").val() : errors.push("*Виберіть населений пункт!");
                ($("#searchPostOffices").val() && $("#searchPostOffices").attr("disabled") !== undefined) ? poshta.ukr_post_office = $("#searchPostOffices").val() : errors.push("*Виберіть відділення!");
            }
        }

        if (!errors.length) {
            $('.btn-order').html('<div class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span></div>');
            $.ajax({
                type: 'POST',
                url: url,
                async: false,
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "pip": pip,
                    "phone": phone,
                    "poshta": poshta
                },
                success: function (response) {
                    $("#error-block").addClass("d-none");
                    location.href = response;
                }
            });
        } else {
            $('.btn-order').html('<i class="fas fa-shipping-fast"></i> Оформити');
            let listErrors = errors.join("<br>");
            $("#error-block").html("<span style='font-weight: bold;'>Ви не заповнили всі дані:</span> <br>" + listErrors);
            $("#error-block").addClass("alert alert-danger");
        }
    });

    // ---------------Apply Filters-------------------------
    var productItems = $(".product-row").children(".product-grid");
    $(".fa-sort-alpha-down, .fa-sort-alpha-up, .fa-sort-numeric-down, .fa-sort-numeric-up").click(function () {
        let sort = "order";
        let mylist = $('.product-row');
        let listitems = mylist.children(".product-grid");
        if ($(this).hasClass("fa-sort-alpha-down")) {
            $(this).removeClass("fa-sort-alpha-down");
            $(this).addClass("fa-sort-alpha-up");
            $(".sort").attr("data-sort", "alpha-up");
            listitems.sort(function(a, b) {
                let compA = a.querySelector(".product-name").textContent;
                let compB = b.querySelector(".product-name").textContent;
                return (compB < compA) ? -1 : (compB > compA) ? 1 : 0;
            })
            $(mylist).append(listitems);
        } else if ($(this).hasClass("fa-sort-alpha-up")) {
            $(this).removeClass("fa-sort-alpha-up");
            $(this).addClass("fa-sort-alpha-down");
            $(".sort").attr("data-sort", "alpha-down");
            listitems.sort(function(a, b) {
                let compA = a.querySelector(".product-name").textContent;
                let compB = b.querySelector(".product-name").textContent;
                return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
            })
            $(mylist).append(listitems);
        } else if ($(this).hasClass("fa-sort-numeric-down")) {
            $(this).removeClass("fa-sort-numeric-down");
            $(this).addClass("fa-sort-numeric-up");
            $(".sort").attr("data-sort", "price-up");
            listitems.sort(function(a, b) {
                let compA = a.querySelector(".product-price").textContent;
                let compB = b.querySelector(".product-price").textContent;
                return (compB < compA) ? -1 : (compB > compA) ? 1 : 0;
            })
            $(mylist).append(listitems);
        } else if ($(this).hasClass("fa-sort-numeric-up")) {
            $(this).removeClass("fa-sort-numeric-up");
            $(this).addClass("fa-sort-numeric-down");
            $(".sort").attr("data-sort", "price-down");
            listitems.sort(function(a, b) {
                let compA = a.querySelector(".product-price").textContent;
                let compB = b.querySelector(".product-price").textContent;
                return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
            })
            $(mylist).append(listitems);
        }

        $(".sort-active").removeClass("sort-active");
        $(this).addClass("sort-active");
    });

    $(".search-btn").click(function () {
        let url = $(".filter-url").attr("data-url");
        applyFilters(url, getSort(), getSearch(), getPrice(), false);
    });

    $('.rangeHandle').on('mouseup touchend', function () {
        if (getSearch() !== "") {
            let url = $(".filter-url").attr("data-url");
            applyFilters(url, getSort(), getSearch(), getPrice(), false);
        } else {
            let url = $(".filter-url").attr("data-url");
            let category_id = $('.category').attr("data-category");
            applyFilters(url, getSort(), getSearch(), getPrice(), category_id);
        }
    });

    function sortProducts(listitems) {
        let sort = getSort();

        if (sort === "alpha-up") {
            listitems.sort(function(a, b) {
                let compA = a.querySelector(".product-name").textContent;
                let compB = b.querySelector(".product-name").textContent;
                return (compB < compA) ? -1 : (compB > compA) ? 1 : 0;
            })
        } else if (sort === "alpha-down") {
            listitems.sort(function(a, b) {
                let compA = a.querySelector(".product-name").textContent;
                let compB = b.querySelector(".product-name").textContent;
                return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
            })
        } else if (sort === "price-up") {
            listitems.sort(function(a, b) {
                let compA = a.querySelector(".product-price").textContent;
                let compB = b.querySelector(".product-price").textContent;
                return (compB < compA) ? -1 : (compB > compA) ? 1 : 0;
            })
        } else if (sort === "price-down") {
            listitems.sort(function(a, b) {
                let compA = a.querySelector(".product-price").textContent;
                let compB = b.querySelector(".product-price").textContent;
                return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
            })
        }

        return listitems;
    }

    function getSort() {
        return $(".sort").attr("data-sort");
    }

    function getSearch() {
        return $(".search-field").val();
    }

    function getPrice() {
        let priceMin = $('[data-handle="0"]').attr("aria-valuenow");
        let priceMax = $('[data-handle="1"]').attr("aria-valuenow");

        return [priceMin, priceMax];
    }

    function applyFilters(url, sort, search, price, category_id) {
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "sort": sort,
                "search": search,
                "price": price,
                "category_id": category_id
            },
            success: function (content) {
                if (search != "") {
                    $(".h-value").text("Результати пошуку");
                } else {
                    $(".h-value").text($(".category").attr("data-category-name"));
                }
                if (!content.length) {
                    $(".container-empty").css("display", "block");
                    $(".product-row").html(content);
                } else {
                    $(".product-row").html(content);
                    productItems = $(".product-row").children(".product-grid");
                    $(".container-empty").css("display", "none");
                }
            }
        });
    }

    $("#clearSearchCities").click(function () {
        $("#searchCities").prop("disabled", false);
        $("#searchCities").val("");
    });

    $("#clearSearchWarehouses").click(function () {
        $("#searchWarehouses").prop("disabled", false);
        $("#searchWarehouses").val("");
    });

    $("#clearSearchCourierCities").click(function () {
        $("#searchCourierCities").prop("disabled", false);
        $("#searchCourierCities").val("");
    });

    $("#clearSearchUkrPoshtaCities").click(function () {
        $("#searchUkrPoshtaCities").prop("disabled", false);
        $("#searchUkrPoshtaCities").val("");
    });

    $("#clearSearchPostOffices").click(function () {
        $("#searchPostOffices").prop("disabled", false);
        $("#searchPostOffices").val("");
    });

    $("#clearSearchUkrPoshtaCourierCities").click(function () {
        $("#searchUkrPoshtaCourierCities").prop("disabled", false);
        $("#searchUkrPoshtaCourierCities").val("");
    });

    $(".btn-menu").click(function () {
        if ($(".sidebar").css('display') == "none") {
            $(".sidebar").css("display", "block");
            $(".btn-menu").html("<i class=\"fas fa-hand-point-left\"></i>&nbsp;MedoBear");
            $(".btn-menu").css("width", "300px");
            $(".product-content").css("display", "none");
            $("body").css("background", "#2d3748");
        } else {
            $(".sidebar").css("display", "none");
            $(".btn-menu").html("<i class=\"fas fa-bars\"></i>");
            $(".btn-menu").css("width", "50px");
            $(".product-content").css("display", "block");
            $("body").css("background", "white");
        }
    });

    $(".copy").click(function () {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).parent().find("span").text()).select();
        document.execCommand("copy");
        $temp.remove();
        $(this).removeClass("fa-copy");
        $(this).addClass("fa-check");
        var el = this;
        setTimeout(function () {
            $(el).removeClass("fa-check");
            $(el).addClass("fa-copy");
        }, 1500);
    });

    $(".btn-copy, .btn-copy .fa-copy").click(function () {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).parent().find(".copy-url").val()).select();
        document.execCommand("copy");
        $temp.remove();
        $('.btn-copy i').removeClass("fa-copy");
        $('.btn-copy i').addClass("fa-check");
        setTimeout(function () {
            $('.btn-copy i').removeClass("fa-check");
            $('.btn-copy i').addClass("fa-copy");
        }, 1500);
    });

    $(".btn-card").click(function () {
        if ($(".btn-card i").hasClass("fa-credit-card")) {

            if ($(".card-input").length) {
                let card = $(".card-input").val();
                let url = $(this).attr("data-url");
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "card": card
                    },
                    success: function (content) {
                        $('.btn-card i').removeClass("fa-credit-card");
                        $('.btn-card i').addClass("fa-edit");
                        $(".card-input").prop("disabled", true);
                    }
                });
            }
        } else {
            $('.btn-card i').removeClass("fa-edit");
            $('.btn-card i').addClass("fa-credit-card");

            $(".card-input").removeAttr("disabled");
        }
    });

    $(".btn-group").click(function () {
        if ($(".btn-group i").hasClass("fa-telegram")) {

            if ($(".group-input").length) {
                let group = $(".group-input").val();
                let url = $(this).attr("data-url");
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "group": group
                    },
                    success: function (content) {
                        $('.btn-group i').removeClass("fa-telegram");
                        $('.btn-group i').removeClass("fab");
                        $('.btn-group i').addClass("fa-edit");
                        $('.btn-group i').addClass("fas");
                        $(".group-input").prop("disabled", true);
                    }
                });
            }
        } else {
            $('.btn-group i').removeClass("fa-edit");
            $('.btn-group i').removeClass("fas");
            $('.btn-group i').addClass("fa-telegram");
            $('.btn-group i').addClass("fab");

            $(".group-input").removeAttr("disabled");
        }
    });

    var numberPage = 0;
    if ($(".count-orders").attr("data-count-orders") < $(".count-orders").attr("data-standart-count")) {
        $("#next").attr("disabled", "disabled");
    }
    $("#next, #prev").click(function () {
        let url = $(this).parent().attr("data-url");
        let link = $(".order-type").attr("data-link");
        let lastOrders = $(".order-type").attr("data-last");

        if(this.id == "next") {
            numberPage++;
            $("#prev").prop("disabled", false);
        } else if (numberPage > 0) {
            numberPage--;
            $("#next").prop("disabled", false);
            if (numberPage == 0) {
                $("#prev").attr("disabled", "disabled");
            }
        }

        showOrders(url, numberPage, link, lastOrders);
    });

    var numberLinksPage = 0;
    if ($(".count-links").attr("data-count-links") < $(".count-links").attr("data-standart-count-links")) {
        $("#stat-next").attr("disabled", "disabled");
    }
    $("#stat-next, #stat-prev").click(function () {
        let url = $(this).parent().attr("data-url");

        if(this.id == "stat-next") {
            numberLinksPage++;
            $("#stat-prev").prop("disabled", false);
        } else if (numberLinksPage > 0) {
            numberLinksPage--;
            $("#stat-next").prop("disabled", false);
            if (numberLinksPage == 0) {
                $("#stat-prev").attr("disabled", "disabled");
            }
        }

        $.ajax({
            type: 'POST',
            url: url,
            async: false,
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "numberPage": numberLinksPage
            },
            success: function (content) {
                if (content) {
                    $(".stat-link-container").html(content);
                    if (!$(".count-links").attr("data-next-page")) {
                        $("#stat-next").attr("disabled", "disabled");
                    }
                }
            }
        });
    });

    $(".btn-show-all").click(function () {
        if ($(this).parent().find(".all-products").hasClass("d-none")) {
            $(this).parent().find(".all-products").removeClass("d-none");
        } else {
            $(this).parent().find(".all-products").addClass("d-none");
        }
    });

    function showOrders(url, numberPage, link, lastOrders) {
        $.ajax({
            type: 'POST',
            url: url,
            async: false,
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "numberPage": numberPage,
                "link": link,
                "lastOrders": lastOrders
            },
            success: function (content) {
                if (content) {
                    $(".orders-container").html(content);
                    if (!$(".count-orders").attr("data-next-page")) {
                        $("#next").attr("disabled", "disabled");
                    }
                }
            }
        });
    }

    $(".show-order-icon").click(function () {
        $(".order-type").attr("data-link", $(this).parent().attr("data-stat-link"));
        $(".order-type").attr("data-last", false);
        $(".order-type").text($(this).parent().attr("data-stat-value"));
        let url = $('.page-block').attr("data-url");
        $("#prev").attr("disabled", "disabled");

        showOrders(url, 0, $(".order-type").attr("data-link"), false);
    });

    $(".show-order-icon-last").click(function () {
        $(".order-type").attr("data-link", $(this).parent().attr("data-stat-link"));
        $(".order-type").attr("data-last", true);
        $(".order-type").text($(this).parent().attr("data-stat-value"));
        let url = $('.page-block').attr("data-url");
        $("#prev").attr("disabled", "disabled");

        showOrders(url, 0, $(".order-type").attr("data-link"), true);
    });

    $("#partner-link").change(function(){
        $('.copy-url').val($(this).val());
    });

    $(function() {
        $('.tooltipOrder').tooltip({
            placement: "bottom",
            trigger: "hover"
        });
    });
});

