$(document).ready(function onDocumentReady() {
    // 맨위로 버튼
    $("#top-button").on("click", function scrollToTop() {
        $("html, body").animate({
            scrollTop: 0,
        }, 400);
    });
});
