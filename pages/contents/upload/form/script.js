$(document).ready(function onDocumentReady() {
    var fileNumber = 0;

    function addFileRow(event) {
        var $files = $("#upload-form .files");
        var template = $files.find("template").html();

        $files
            .append($("<li>")
                .html(template)
                .find(".file-label")
                .attr("for", "file-" + fileNumber)
                .end()
                .find(".file-input")
                .attr("id", "file-" + fileNumber)
                .end());

        fileNumber += 1;

        if (event !== undefined) {
            event.preventDefault();
        }
    }

    $("#upload-form .add-file").on("click", addFileRow);
    addFileRow();
});
