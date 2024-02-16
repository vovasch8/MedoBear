
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
});
