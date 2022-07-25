$(function () {

    $(".btn-menu-toggler").on("click", function (e) {
        e.preventDefault();
        let sidebar = $("#sidebar");
        let aci = $(this).attr("data-active-icon");
        let ali = $(this).attr("data-alt-icon");

        if (sidebar.hasClass("d-none")) {
            sidebar.removeClass("d-none");
            altIcon();
        } else {
            sidebar.addClass("d-none");
            altIcon();
        }

        function altIcon() {
            $(this).attr("data-active-icon", ali)
                .attr("data-alt-icon", aci)
                .removeClass(aci)
                .addClass(ali);
        }
    });

});
