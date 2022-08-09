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
    let modalImageToolsForm = modalImageTools.find("form");

    /**
     * 
     * remove classe jsFormSubmit pois a submissão do formulário será tratado de maneira particular
     * e não da forma padrão
     * 
     */
    modalImageToolsForm.removeClass("jsFormSubmit");

    $(".jsBtnImageUploadModal").on("click", function (e) {
        e.preventDefault();
        let button = $(this);

        modal.find("form").attr("action", button.attr("data-action"));
        modal.find(".title").html("Upload de nova imagem");

        modal.modal();

    });

    modalImageToolsForm.on("submit", function (e) {
        e.preventDefault();

        formSubmit(e, $(this), null, function (response) {

            if (!response.success)
                return;

            let itemClone = modalImageTools.find(".model .image-list-item").clone();

            itemClone.find("#image-id").val(response.id);
            itemClone.find("#image-url").val(response.url);
            itemClone.find("#image-thumb").val(response.thumb);
            itemClone.find(".img-fluid").attr("src", response.thumb);

            modalImageTools.find(".image-list").prepend(itemClone.hide().show("fade"));

        }, null, null);

    });

    /**
     * reseta modal jsImageUploadModal
     */
    modal.on("hidden.bs.modal", function () {

        modal.find("form").attr("action", "");
        modal.find(".message-area").html("");

        modal.find("#image").val("");
        modal.find("#tags").val("");
        modal.find("#name").val("");

        addFormErrors($(modal.find("form"), []));

    });

    /**
     * reseta modal jsImageToolsModal
     */
    modalImageTools.on("hidden.bs.modal", function () {

        modal.find("form").attr("action", "");
        modal.find(".message-area").html("");

        modal.find("#image").val("");
        modal.find("#tags").val("");
        modal.find("#name").val("");

        addFormErrors($(modal.find("form"), []));

    });

});