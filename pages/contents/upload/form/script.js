$(document).ready(function onDocumentReady() {
    var fileNumber = 0;

    function enableURLApply() {
        $(this).find(".url-apply").addClass("on");
    }

    function disableURLApply(e) {
        var $button = $(this).find(".url-apply");

        if (e.relatedTarget !== $button.get(0)) {
            $button.removeClass("on");
        }
    }

    function showFileDialog(event) {
        event.preventDefault();
        $("#" + $(this).data("for")).click();
    }

    function addFileRow(event) {
        var $files = $("#upload-form .files");
        var template = $files.find("template").html();

        $files
            .append($("<li>")
                .html(template)
                .find(".url")
                    .on("focusin", enableURLApply)
                    .on("focusout", disableURLApply)
                .end()
                .find(".select-file-input")
                    .attr("id", "file-" + fileNumber)
                .end()
                .find(".select-file-button")
                    .data("for", "file-" + fileNumber)
                    .on("click", showFileDialog)
                .end());

        fileNumber += 1;

        if (event !== undefined) {
            event.preventDefault();
        }
    }

    $("#upload-form .add-file").on("click", addFileRow);

    addFileRow();
});
