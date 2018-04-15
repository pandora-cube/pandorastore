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

    function showFileName($li, fileName) {
        /* eslint-disable indent */
        $li
            .find(".file-input")
                .addClass("disabled")
                .end()
            .find(".file-name")
                .addClass("enabled")
                .val(fileName)
                .end();
        /* eslint-enable */
    }

    function onFileChanged() {
        var $li = $(this).parents("#upload-form .files li");
        var file = this.files[0];

        if (file !== undefined) {
            showFileName($li, file.name);
        }
    }

    function onFileURLEntered() {
        var $li = $(this).parents("#upload-form .files li");
        var fileName = $li.find(".url-input").val();

        if (fileName.length > 0) {
            showFileName($li, fileName);
        } else {
            alert("파일 URL을 입력하십시오.");
        }

        event.preventDefault();
    }

    function deleteFileRow(event) {
        $(this).parents("#upload-form .files li").remove();
        event.preventDefault();
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
                    .find(".url-apply")
                        .on("click", onFileURLEntered)
                        .end()
                    .end()
                .find(".select-file")
                    .attr("id", "file-" + fileNumber)
                    .on("change", onFileChanged)
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
