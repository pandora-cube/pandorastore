function onAccountCheckResponse(id, json, focus) {
    var data = $.parseJSON(json);
    var $label = $("#label" + data[0]);
    var $dest = $("#" + id);

    if (focus === undefined) {
        focus = false;
    }

    if (data[1] === 0) { // 사용 불가능한 계정인 경우
        $label
            .removeClass("satisfy")
            .addClass("warning")
            .find(".alert")
            .text(data[2]);
        $dest.data("checked", false)
            .siblings("input").not(".not-check").data("checked", false);
    } else if (data[1] === 1) { // 사용 가능한 계정인 경우
        $label
            .removeClass("warning")
            .addClass("satisfy")
            .find(".alert")
            .text(data[2]);
        $dest.data("checked", true)
            .siblings("input").not(".not-check").data("checked", true);
    } else { // 잘못된 값이 반환된 경우
        $label
            .removeClass("satisfy")
            .removeClass("warning")
            .find(".alert")
            .text("");
        if (data[2] !== undefined) {
            $label
                .find(".alert")
                .text(data[2]);
        }
        $dest.removeData("checked")
            .siblings("input").not(".not-check").removeData("checked");
    }

    if (focus === true) {
        $dest.focus();
    }
}

$(document).ready(function onDocumentReady() {
    function checkAccount() {
        var id = this.id;
        var value = this.value;
        var data = {};

        if (this.type === "radio") {
            value = this.checked;
        }

        data[id] = value;
        if ($(this).parent().hasClass("siblings")) {
            $(this).siblings("input").not(".not-check").each(function addSibling() {
                if (this.type === "radio") {
                    data[this.id] = this.checked;
                } else {
                    data[this.id] = this.value;
                }
            });
        }

        $.post("/accounts/signup_check", {
            Key: id,
            Data: data,
        }).done(function onSuccess(json) {
            onAccountCheckResponse(id, json);
        });
    }

    function toggleInnerForm() {
        var $form = $(".inner-form");
        var toggle = $("#PCubeMember").is(":checked");

        if (toggle) {
            $form.slideDown();
        } else {
            $form.slideUp();
        }
        $form.find("input").each(function toggleRequired() {
            this.required = toggle;
        });
    }

    function onSubmit(event) {
        $("#signup-form input").not(".not-check").each(function checkInput() {
            if ((this.required === true && $(this).data("checked") !== true)
            || $(this).data("checked") === false) {
                if (this.type !== "radio") {
                    $(this).focus();
                }
                event.preventDefault();
            }
        });
    }

    $("#signup-form input").not(".not-check")
        .on("change", checkAccount)
        .on("keyup", checkAccount)
        .each(checkAccount);
    $("#PCubeMember")
        .on("change", toggleInnerForm)
        .each(toggleInnerForm);
    $("#signup-form")
        .on("submit", onSubmit);
});
