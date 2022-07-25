(function ($) {

    $.fn.submited = function (event, before = null, success = null, complete = null, error = null) {
        event.preventDefault();

        let form = $(this);
        let data = new FormData(form[0]);
        let action = form.attr("action");
        let submitter = $(event.originalEvent.submitter);

        $.ajax({
            type: "POST",
            url: action,
            data: data,
            dataType: "json",
            contentType: false,
            processData: false,
            timeout: 20000,

            beforeSend: function () {
                addLoadingMode(submitter);
                addBackdrop("formSubmitBkdp", "absolute", form.parent());

                if (before) before();
            },

            success: function (response) {
                if (response.reload) {
                    window.location.reload();
                    return;
                }

                if (response.redirect) {
                    window.location.href = response.redirect;
                    return;
                }

                addFormErrors(form, response.errors);

                if (success) success(response);
            },

            complete: function (response) {
                removeLoadingMode(submitter);
                removeBackdrop("formSubmitBkdp");

                if (complete) complete(response);
            },

            error: function (response) {
                if (error) error(response);
            }
        });
    };


    /**
     *
     * FUNÇÕES: BACKDROP
     *
     */

    /**
     * @param {String} id id para o backdrop
     * @param {String} position tipo de posicionamento. Padrão é 'absolute'
     * @param {jQuery} container onde inserir o backdrop.
     * @param {String} effect efeito do jquery-ui. Padrão é 'fade'
     */
    function addBackdrop(id, position, container, effect) {
        let cntnr = container ?? $("body");
        let efct = effect ?? "fade";
        let bkdrop = $(`<div class="mbackdrop loading rounded" id="${id}"></div>`).css({
            "background-color": "rgb(0, 0, 0, 0.125)",
            width: "100%",
            height: "100%",
            position: position ?? "absolute",
            top: 0,
            left: 0,
            "z-index": 998,
        }).hide();

        cntnr.append(bkdrop.show(efct));
    }

    /**
     * @param {String} id id do backdrop a ser removido
     * @param {String} container local onde procurar o backdrop. Por padrão busca por todo o 'body'
     * @param {String} effect efeito do jquery-ui. Padrão é 'fade'
     */
    function removeBackdrop(id, container, effect) {
        let cntnr = $(container ?? "body");
        let efct = effect ?? "fade";

        cntnr.find("#" + id).hide(efct, function () {
            $(this).remove();
        });
    }

    /**
     *
     * FUNÇÕES: BOTÕES
     *
     */

    /**
     * @param {jQuery} buttonObject objeto jQuery do botão
     */
    function addLoadingMode(buttonObject) {
        buttonObject
            .removeClass(buttonObject.attr("data-active-icon"))
            .addClass(buttonObject.attr("data-alt-icon"))
            .prop("disabled", true);
    }

    /**
     * @param {jQuery} buttonObject objeto jQuery do botão
     */
    function removeLoadingMode(buttonObject) {
        buttonObject
            .addClass(buttonObject.attr("data-active-icon"))
            .removeClass(buttonObject.attr("data-alt-icon"))
            .prop("disabled", false);
    }

    /**
     * @param {jQuery} formObject
     * @param {Array} errs
     */
    function addFormErrors(formObject, errs) {
        let fields = formObject.find("input, select, textarea");
        let errors = errs ?? [];

        if (!fields.length) return;

        $.each(fields, function (fieldKey, field) {
            let fieldObj = $(field);
            let fieldName = fieldObj.attr("name");

            if (errors[fieldName]) {
                let invalid = fieldObj.parent().find(".invalid-feedback");

                if (invalid.length) invalid.html(errors[fieldName]);
                else fieldObj.parent().append(`<div class="invalid-feedback">${errors[fieldName]}</div>`);

                fieldObj.addClass("is-invalid");
            } else {
                fieldObj
                    .removeClass("is-invalid")
                    .parent().find(".invalid-feedback").hide("fade", function () {
                        $(this).remove();
                    });
            }
        });
    }

}(jQuery));
