$(document).ready(function onDocumentReady() {
    function checkAccount() {
        var id = this.id;

        $.post("/functions/checkaccount.php", {
            key: id,
            value: this.value,
        }).done(function onSuccess(json) {
            var data = $.parseJSON(json);
            var $label = $("label[for=" + id + "]");

            if (data[0] === 0) { // 사용 불가능한 계정인 경우
                $label
                    .removeClass("satisfy")
                    .addClass("warning")
                    .find(".alert")
                    .text(data[1]);
            } else if (data[0] === 1) { // 사용 가능한 계정인 경우
                $label
                    .removeClass("warning")
                    .addClass("satisfy")
                    .find(".alert")
                    .text(data[1]);
            } else { // 잘못된 값이 반환된 경우
                $label
                    .removeClass("satisfy")
                    .removeClass("warning")
                    .find(".alert")
                    .text("");
                if (data[1] !== undefined) {
                    $label
                        .find(".alert")
                        .text(data[1]);
                }
            }
        }).fail(function onFail() {
        });
    }

    function checkPassword() {
        var password = $("#Password").val();
        var passwordAgain = $("#PasswordAgain").val();

        if (password.length === 0 && passwordAgain.length === 0) {
            $("#labelPassword")
                .removeClass("satisfy")
                .removeClass("warning")
                .find(".alert")
                .text("");
        } else if (password === passwordAgain) {
            $("#labelPassword")
                .removeClass("warning")
                .addClass("satisfy")
                .find(".alert")
                .text("");
        } else if (password.indexOf(passwordAgain) === 0) {
            $("#labelPassword")
                .removeClass("satisfy")
                .removeClass("warning")
                .find(".alert")
                .text("");
        } else if (passwordAgain.length > 0) {
            $("#labelPassword")
                .removeClass("satisfy")
                .addClass("warning")
                .find(".alert")
                .text("비밀번호를 다시 확인해 주세요.");
        } else {
            $("#labelPassword")
                .removeClass("satisfy")
                .removeClass("warning")
                .find(".alert")
                .text("");
        }
    }

    function toggleInnerForm() {
        var $form = $(".inner-form");
        var toggle = $("#PCubeMember").is(":checked");

        $form.slideToggle(toggle);
        $form.find("input").each(function toggleRequired() {
            this.required = toggle;
        });
    }

    $("#Nickname, #UserID")
        .on("change", checkAccount)
        .on("keyup", checkAccount);
    $("#Password, #PasswordAgain")
        .on("change", checkPassword)
        .on("keyup", checkPassword);
    $("#PCubeMember")
        .on("change", toggleInnerForm);
});
