$(document).ready(function onDocumentReady() {
    function checkUserID() {
        $.post("/functions/checkaccount.php", {
            UserID: $("#UserID").val(),
        }).done(function onSuccess(json) {
            var data = $.parseJSON(json);

            if (data[0] === 0) { // 사용 불가능한 계정인 경우
                $("#labelUserID")
                    .removeClass("satisfy")
                    .addClass("warning")
                    .find(".alert")
                    .text(data[1]);
            } else if (data[0] === 1) { // 사용 가능한 계정인 경우
                $("#labelUserID")
                    .removeClass("warning")
                    .addClass("satisfy")
                    .find(".alert")
                    .text(data[1]);
            } else { // 잘못된 값이 반환된 경우
                $("#labelUserID")
                    .removeClass("satisfy")
                    .removeClass("warning")
                    .find(".alert")
                    .text("");
                if (data[1] !== undefined) {
                    $("#labelUserID").find(".alert").text(data[1]);
                }
            }
        }).fail(function onFail() {
        });
    }

    function checkPassword() {
    }

    $("#UserID")
        .on("change", checkUserID)
        .on("keyup", checkUserID);
    $("#Password, #PasswordAgain").change(checkPassword);
});
