$(document).ready(function onDocumentReady() {
    function checkAccount() {
        var id = this.id;
        var $sibling = $(this).siblings("#" + id + "Check");
        var value = this.value;
        var valueCheck = null;

        if ($sibling.length > 0) {
            valueCheck = $sibling.val();
        } else if (id.substr(-5, 5) === "Check") {
            id = id.substr(0, id.length - 5);
            $sibling = $(this).siblings("#" + id);
            valueCheck = value;
            value = $sibling.val();
        }

        $.post("/functions/checkaccount.php", {
            Key: id,
            Value: value,
            ValueCheck: valueCheck,
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

    function toggleInnerForm() {
        var $form = $(".inner-form");
        var toggle = $("#PCubeMember").is(":checked");

        $form.slideToggle(toggle);
        $form.find("input").each(function toggleRequired() {
            this.required = toggle;
        });
    }

    $("#Nickname, #UserID, #Password, #PasswordCheck")
        .on("change", checkAccount)
        .on("keyup", checkAccount);
    $("#PCubeMember")
        .on("change", toggleInnerForm);
});
