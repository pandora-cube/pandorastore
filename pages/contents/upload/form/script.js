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

    function deleteFileRow(event) {
        event.preventDefault();
        $(this).parents("#upload-form .files li").remove();
    }

    function addFileRow(event) {
        var $files = $("#upload-form .files");
        var template = $files.find("template").html();

        function getFileInputName() {
            return this.name + "-" + fileNumber;
        }

        /* eslint-disable indent */
        $files
            .append($("<li>")
                .html(template)
                .find("input:not([name=MAX_FILE_SIZE])")
                    .attr("name", getFileInputName)
                    .end()
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
                    .end()
                .find(".delete")
                    .on("click", deleteFileRow)
                    .end());
        /* eslint-enable */

        fileNumber += 1;

        if (event !== undefined) {
            event.preventDefault();
        }
    }

    $("#upload-form .add-file").on("click", addFileRow);

    addFileRow();
});
