$(document).ready(function onDocumentReady() {
    function onReasonSelected() {
        if (this.value === "기타") {
            $("#Detail")
                .slideDown()
                .focus();
        } else {
            $("#Detail")
                .slideUp();
        }
    }

    $("#leave-form input[type=radio]")
        .on("change", onReasonSelected);
});
