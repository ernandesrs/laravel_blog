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

/**
 * 
 * Modal ImageUploadModal e jsImageToolsModal
 * 
 */
$(function () {

    let modalImageUpload = $("#jsImageUploadModal");
    let modalImageTools = $("#jsImageToolsModal");
    let modalImageToolsImageUploadForm = modalImageTools.find(".jsFormSubmit");

    /**
     * 
     * remove classe jsFormSubmit pois a submissão do formulário será tratado de maneira particular
     * e não da forma padrão
     * 
     */
    modalImageToolsImageUploadForm.removeClass("jsFormSubmit").addClass("jsImageToolsModalImageUpload");

    /**
     * ao fazer um upload no formulário do modal modalImageTools
     */
    modalImageToolsImageUploadForm.on("submit", function (e) {
        formSubmit(e, $(this), null, function (response) {
            if (!response.success)
                return;

            let itemClone = modalImageTools.find(".model .images-list-item").clone().hide();

            itemClone.find("#image-id").val(response.id);
            itemClone.find("#image-url").val(response.url);
            itemClone.find("#image-thumb").val(response.thumb);
            itemClone.find(".img-fluid").attr("src", response.thumb).attr("title", response.tags).attr("data-original-title", response.tags);

            let allItems = modalImageTools.find(".images-list .list .images-list-item");

            if (allItems.length == 9) {
                $(allItems[8]).fadeOut(function () {
                    $(this).remove();
                    addItemClone(itemClone);
                });
            } else addItemClone(itemClone);

        }, null, null);

        function addItemClone(clone) {
            modalImageTools.find(".images-list .list").prepend(clone.show("fade"));
        }
    });

    /**
     * ao realizar uma pesquisa no formulário de busca do modal modalImageTools
     */
    modalImageTools.on("submit", ".jsImageToolsModalSearchFormSubmit", function (e) {
        formSubmit(e, $(this), null, function (response) {
            if (response.success) {
                modalImageTools.find(".images-list .list").html("");
                modalImageTools.find(".images-pagination").html("");

                $.each(response.images, function (index, value) {
                    let clone = modalImageTools.find(".images-list .model .images-list-item").clone().hide();

                    clone.find(".img-fluid")
                        .attr("src", value.thumb)
                        .attr("alt", value.name)
                        .attr("title", value.tags)
                        .attr("data-original-title", value.tags);

                    clone.find("#image-name").val(value.name);
                    clone.find("#image-id").val(value.id);
                    clone.find("#image-thumb").val(value.thumb);
                    clone.find("#image-url").val(value.url);

                    modalImageTools.find(".list").append(clone.show("fade"));
                });

                modalImageTools.find(".images-pagination").html(response.pagination);
            }
        });

    });

    /**
     * ao clicar no link de navegação de página do modal modalImageTools
     */
    modalImageTools.on("click", ".page-link", function (e) {
        e.preventDefault();

        ajaxRequest($(this).attr("href"), null, null,
            // success
            function (response) {
                if (response.success) {

                    modalImageTools.find(".list").html("");

                    $.each(response.images, function (index, value) {
                        let clone = modalImageTools.find(".images-list .model .images-list-item").clone().hide();

                        clone.find(".img-fluid")
                            .attr("src", value.thumb)
                            .attr("alt", value.name)
                            .attr("title", value.tags)
                            .attr("data-original-title", value.tags);

                        clone.find("#image-name").val(value.name);
                        clone.find("#image-id").val(value.id);
                        clone.find("#image-thumb").val(value.thumb);
                        clone.find("#image-url").val(value.url);

                        modalImageTools.find(".list").append(clone.show("fade"));

                    });

                    modalImageTools.find(".images-pagination").html(response.pagination);
                }
            }, null, null, "POST"
        );
    });

    /**
     * ao abrir modal modalImageTools
     */
    modalImageTools.on("shown.bs.modal", function () {
        if (modalImageTools.find(".list .images-list-item").length)
            return;

        ajaxRequest(modalImageTools.find(".images-list").attr("data-action"), null, null,
            // success
            function (response) {
                if (response.success) {
                    $.each(response.images, function (index, value) {
                        let clone = modalImageTools.find(".images-list .model .images-list-item").clone().hide();

                        clone.find(".img-fluid")
                            .attr("src", value.thumb)
                            .attr("alt", value.name)
                            .attr("title", value.tags)
                            .attr("data-original-title", value.tags);

                        clone.find("#image-name").val(value.name);
                        clone.find("#image-id").val(value.id);
                        clone.find("#image-thumb").val(value.thumb);
                        clone.find("#image-url").val(value.url);

                        modalImageTools.find(".list").append(clone.show("fade"));

                    });

                    modalImageTools.find(".images-pagination").html(response.pagination);
                }
            }, null, null, "POST"
        );
    });

    /**
     * reseta modal jsImageUploadModal
     */
    modalImageUpload.on("hidden.bs.modal", function () {

        modalImageUpload.find("form").attr("action", "");
        modalImageUpload.find(".message-area").html("");

        modalImageUpload.find("#image").val("");
        modalImageUpload.find("#tags").val("");
        modalImageUpload.find("#name").val("");

        addFormErrors($(modalImageUpload.find("form"), []));

    });

    /**
     * reseta modal jsImageToolsModal
     */
    modalImageTools.on("hidden.bs.modal", function () {

        modalImageTools.find(".message-area").html("");

        modalImageTools.find("#image").val("");
        modalImageTools.find("#tags").val("");
        modalImageTools.find("#name").val("");

        addFormErrors($(modalImageTools.find(".jsImageToolsModalImageUpload"), []));

    });

});