let timeoutHandler = null;

$(function () {
    $('[data-toggle="tooltip"]').tooltip()

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

$(function () {
    let messageArea = $(".message-area");
    let modal = $(".jsModalConfirmation");

    $(document).on("submit", ".jsFormSubmit", function (e) {
        let form = $(this);
        messageArea = form.find(".message-area").length ? form.find(".message-area") : messageArea;

        form.submited(e, null, function (response) {
            // success
            if (response.message)
                addAlert($(response.message), messageArea);

            addFormErrors(form, response.errors);
        }, function (response) {
            // complete
            if (response.responseJSON) {
                let resp = response.responseJSON;
                let errors = resp.errors;

                if (message = errors.message) {
                    addAlert($(message[0]), messageArea);
                }

                addFormErrors(form, errors);
            } else {
                addAlert($(`<div class="alert alert-danger text-center"><small>Sem resposta do servidor. Verifique sua coenxão ou se isso persistir entre em contato.</small></div>`), messageArea);
            }
        }, function () {
            // error
        });
    });

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
* ALERTA/MENSAGENS
*/
$(function () {
    let messageAreas = $(".message-area");

    $.each(messageAreas, function (k, v) {
        let alert = $(v).find(".alert");

        if (alert.length) {
            showAlert(alert);
        }
    });

    $(".alert").on("close.bs.alert", function () {
        if (timeoutHandler)
            clearTimeout(timeoutHandler);
    });
});

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
 *
 * FUNÇÕES: ALERTS/MESSAGES
 *
 */

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
        runTimer(alert);
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
function runTimer(alert) {
    timeoutHandler = setTimeout(function () {
        removeAlert(alert);
    }, timer * 1000);
}
