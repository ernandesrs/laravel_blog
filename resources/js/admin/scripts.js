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

$(function () {

    let modal = $("#jsImageUploadModal");
    let modalImageTools = $("#jsImageToolsModal");

    modalImageTools.modal();

    $(".jsBtnImageUploadModal").on("click", function (e) {
        e.preventDefault();
        let button = $(this);

        modal.find("form").attr("action", button.attr("data-action"));
        modal.find(".title").html("Upload de nova imagem");

        modal.modal();

    });

    modal.on("hidden.bs.modal", function () {

        modal.find("form").attr("action", "");
        modal.find(".message-area").html("");

        modal.find("#image").val("");
        modal.find("#tags").val("");
        modal.find("#name").val("");

        addFormErrors($(modal.find("form"), []));

    });

    modalImageTools.on("hidden.bs.modal", function(){
        
        modal.find("form").attr("action", "");
        modal.find(".message-area").html("");

        modal.find("#image").val("");
        modal.find("#tags").val("");
        modal.find("#name").val("");

        addFormErrors($(modal.find("form"), []));

    });

});