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

            let itemClone = modalImageTools.find(".model .images-list-item").clone().hide();

            itemClone.find("#image-id").val(response.id);
            itemClone.find("#image-url").val(response.url);
            itemClone.find("#image-thumb").val(response.thumb);
            itemClone.find(".img-fluid").attr("src", response.thumb).attr("title", response.tags).attr("data-original-title", response.tags);

            let allItems = modalImageTools.find(".images-list .list .images-list-item");
            console.log(allItems.length);
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

    modalImageTools.on("click", ".page-link", function (e) {
        e.preventDefault();

        $.post($(this).attr("href"), null,
            function (data, textStatus, jqXHR) {
                if (data.success) {

                    modalImageTools.find(".list").html("");

                    $.each(data.images, function (index, value) {
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

                        modalImageTools.find(".list").append(clone.fadeIn());

                    });

                    modalImageTools.find(".images-pagination").html(data.pagination);
                }
            },
            "json"
        );
    });

    modalImageTools.on("shown.bs.modal", function () {
        if (modalImageTools.find(".list .images-list-item").length)
            return;

        $.post(modalImageTools.find(".images-list").attr("data-action"), null,
            function (data, textStatus, jqXHR) {
                if (data.success) {
                    $.each(data.images, function (index, value) {
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

                        modalImageTools.find(".list").append(clone.fadeIn());

                    });

                    modalImageTools.find(".images-pagination").html(data.pagination);
                }
            },
            "json"
        );
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