let timeoutHandler = null;

/**
 * CSRF TOKEN
 * BOOTSTRAP TOOLTIPS
 * SUBMISSÃO DE FORMULÁRIO
 * MENSAGENS DE ALERTA
 */
$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
        }
    });

    /**
     * 
     * bootstrap tooltip
     * 
     */
    $("[data-toggle='tooltip']").tooltip();

    /**
     * 
     * submissão de formulário
     * 
     */
    $(document).on("submit", ".jsFormSubmit", function (e) {
        formSubmit(e, $(this));
    });

    /**
     * 
     * MOSTRA/FECHAR MENSAGENS DE ALERTAS
     * 
     */
    let messageAreas = $(".message-area");

    $.each(messageAreas, function (k, v) {
        let alert = $(v).find(".alert");

        if (k == 0 && alert.length) {
            showAlert(alert);
        } else {
            alert.remove();
        }
    });

    $(".alert").on("close.bs.alert", function () {
        if (timeoutHandler)
            clearTimeout(timeoutHandler);
    });
});

/**
 * MODAIS/TELAS DE CONFIRMAÇÃO
 */
$(function () {
    let modal = $(".jsModalConfirmation");

    $(".jsButtonConfirmation").on("click", function (e) {
        e.preventDefault();
        let button = $(this);

        modal.find(".jsFormSubmit").attr("action", button.attr("data-action"));
        modal.find(".confirmation-message")
            .addClass(`text-${button.attr("data-type")}`)
            .html(button.attr("data-message"));
        modal.find(".confirmation-btn")
            .addClass(`btn-${button.attr("data-type")}`);

        modal.modal();
    });

    $(modal).on("hidden.bs.modal", function (e) {
        modal.find(".message-area").html("");
        modal.find(".jsFormSubmit").attr("action", "");
        modal.find(".confirmation-message")
            .removeClass(`text-danger text-success text-info text-warning text-secondary`)
            .html("");
        modal.find(".confirmation-btn")
            .removeClass(`btn-danger btn-success btn-info btn-warning btn-secondary`);
    });

});

/**
 * 
 * FUNÇÕES
 * 
 */

/**
 * @param {JQuery.SubmitEvent} event 
 * @param {jQuery} form 
 * @param {Function} before 
 * @param {Function} success 
 * @param {Function} complete 
 * @param {Function} error 
 * @param {String} method 
 */
function formSubmit(event, form, before = null, success = null, complete = null, error = null, method = "POST") {
    event.preventDefault();
    let data = new FormData(form[0]);
    let action = form.attr("action");
    let submitter = $(event.originalEvent.submitter);
    let messageArea = form.find(".message-area").length ? form.find(".message-area") : $(".message-area");

    ajaxRequest(action, data,
        // beforeSend
        function () {
            // loading add
            submitter
                .removeClass(submitter.attr("data-active-icon"))
                .addClass(submitter.attr("data-alt-icon"))
                .prop("disabled", true);

            // backdrop add
            form.parent().append(
                $(`<div class="mbackdrop loading rounded" id="jsFormSubmitBackdrop"></div>`)
                    .css({
                        "background-color": "rgb(0, 0, 0, 0.125)",
                        "width": "100%",
                        "height": "100%",
                        "position": "absolute",
                        "top": "0",
                        "left": "0",
                        "z-index": "998",
                    }).hide().show("fade")
            );

            if (before) before();
        },

        // success
        function (response) {
            if (response.reload) {
                window.location.reload();
                return;
            }

            if (response.redirect) {
                window.location.href = response.redirect;
                return;
            }

            if (response.message)
                addAlert($(response.message), messageArea);

            if (response.errors ?? null)
                addFormErrors(form, response.errors);

            if (success) success(response);
        },

        // complete
        function (response) {
            // loading remove
            submitter
                .addClass(submitter.attr("data-active-icon"))
                .removeClass(submitter.attr("data-alt-icon"))
                .prop("disabled", false);

            // backdrop remove
            form.parent().find("#jsFormSubmitBackdrop").hide("fade", function () {
                $(this).remove();
            });

            if (response.responseJSON) {
                let resp = response.responseJSON;
                let errors = resp.errors ?? null;

                if (errors && (errors.message ?? null)) {
                    addAlert($(errors.message[0]), messageArea);
                }

                if (errors)
                    addFormErrors(form, errors);
            } else {
                addAlert($(`<div class="alert alert-danger text-center">
                                <small>
                                    Sem resposta do servidor. Verifique sua coenxão ou se isso persistir entre em contato.
                                </small>
                            </div>`), messageArea);
            }

            if (complete) complete(response);
        },

        // error
        function (response) {
            if (error) error(response);
        }
    );
}

/**
 * @param {String} url 
 * @param {FormData} data 
 * @param {Function} before 
 * @param {Function} success 
 * @param {Function} complete 
 * @param {Function} error 
 * @param {String} method request method(POST/GET)
 */
function ajaxRequest(url, data = null, before = null, success = null, complete = null, error = null, method = "POST") {
    $.ajax({
        type: method,
        url: url,
        data: data,
        dataType: "json",
        contentType: false,
        processData: false,
        timeout: 20000,

        beforeSend: function () {
            if (before) before();
        },

        success: function (response) {
            if (success) success(response);
        },

        complete: function (response) {
            if (complete) complete(response);
        },

        error: function (response) {
            if (error) error(response);
        }
    });
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

/**
 * @param {jQuery} alert objeto jquery do elemento de mensagem
 * @param {jQuery|null} container objeto jquery do container de mensagem. Padrão será o primeiro .message-area encontrado
 */
function addAlert(alert, container = null) {
    let cntnr = container ?? $(".message-area");
    cntnr.html(alert);
    showAlert(alert);
}

/**
 * @param {jQuery} alert
 */
function showAlert(alert) {
    if (alert.hasClass("alert-float")) {
        alert.show("blind", function () {
            $(this).effect("bounce");
        });
    } else {
        alert.show("fade");
    }

    if (timer = alert.attr("data-timer")) {
        if (timeoutHandler)
            clearTimeout(timeoutHandler);
        alertRunTimer(alert);
    }
}

/**
 * @param {jQuery} alert
 */
function removeAlert(alert) {
    if (alert.hasClass("alert-float")) {
        alert.effect("bounce", function () {
            $(this).hide("blind", function () {
                $(this).remove();
            });
        });
    } else {
        alert.hide("fade", function () {
            $(this).remove();
        });
    }
}

/**
 * @param {jQuery} alert
 */
function alertRunTimer(alert) {
    timeoutHandler = setTimeout(function () {
        removeAlert(alert);
    }, timer * 1000);
}
