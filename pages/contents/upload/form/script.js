$(document).ready(function onDocumentReady() {
    var fileNumber = 0;

    function insertDownloadInput(event) {
        var $downloads = $("#upload-form .downloads");
        var template = $downloads.find("template").html();

        $downloads
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

    $("#upload-form .add-download").on("click", insertDownloadInput);
    insertDownloadInput();
});
