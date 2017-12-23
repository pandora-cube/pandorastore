$(document).ready(function onDocumentReady() {
    $(".open-search").click(function openSearchForm() {
        $(".search").slideToggle();
    });
});

function setSearchText(text) {
    $("input[name=search]").val(text);

    if (text.length > 0) {
        $(".search").css("display", "block");
    }
}
