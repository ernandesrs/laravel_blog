$(function () {

    $(".btn-menu-toggler").on("click", function (e) {
        e.preventDefault();
        let sidebar = $("#sidebar");

        if (sidebar.hasClass("d-none")) {
            sidebar.removeClass("d-none");
            altIcon($(this));
        } else {
            sidebar.addClass("d-none");
            altIcon($(this));
        }

    });

    $(".jsShowMoreFilters").on("click", function (e) {
        e.preventDefault();
        altIcon($(this));
    });

    function altIcon(buttonObj) {
        let aci = buttonObj.attr("data-active-icon");
        let ali = buttonObj.attr("data-alt-icon");

        buttonObj.attr("data-active-icon", ali)
            .attr("data-alt-icon", aci)
            .removeClass(aci)
            .addClass(ali);
    }

});
