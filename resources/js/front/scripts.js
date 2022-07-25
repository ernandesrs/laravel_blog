$(function () {

    $(".jsBtnToggler").on("click", function (e) {
        e.preventDefault();

        if ($(".sidebar").hasClass("show")) {
            $(".sidebar").slideUp(125, function () {
                $(this).removeClass("show").attr("style", "");
            });
        } else {
            $(".sidebar").slideDown(250, function () {
                $(this).addClass("show").attr("style", "");
            });
        }
    });

});