$(document).ready(function onDocumentReady() {
    $(".open-search").click(function openSearchForm() {
        $(".search").slideToggle();
    });

    // 사용자 버튼
    $(".user-menu button").click(function openUserMenu() {
        var $overlay = $(this).siblings(".overlay");
        if ($overlay.css("display") !== "block") { // 오버레이가 닫혀 있는 경우
            $(this).hide();
            $(this).siblings("button.opened").show();
            $overlay.addClass("opened").fadeIn();
        }
    });
    $(document).mouseup(function closeUserMenu(e) {
        $(".user-menu .overlay.opened").each(function closeOverlay() {
            if ($(this).has(e.target).length === 0) { // 열려 있는 사용자 메뉴 바깥을 클릭한 경우
                $(this).siblings("button.closed").show();
                $(this).siblings("button.opened").hide();
                $(this).removeClass("opened").fadeOut();
            }
        });
    });
});

function setSearchText(text) {
    $("input[name=search]").val(text);

    if (text.length > 0) {
        $(".search").css("display", "block");
    }
}
