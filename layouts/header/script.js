$(document).ready(function onDocumentReady() {
    $(".open-search").click(function openSearchForm() {
        $(".search").slideToggle();
    });

    // 사용자 메뉴
    $(".user-menu-button").click(function openUserMenu() {
        var $menu = $(this).siblings(".user-menu");
        if ($menu.css("display") !== "block") { // 사용자메뉴가 닫혀 있는 경우
            $menu.fadeIn();
        }
    });
    $(document).mouseup(function closeUserMenu(e) {
        var $menu = $(".user-menu");
        if ($menu.css("display") === "block" && $menu.has(e.target).length === 0) { // 열려 있는 사용자 메뉴 바깥을 클릭한 경우
            $menu.fadeOut();
        }
    });
});

function setSearchText(text) {
    $("input[name=search]").val(text);

    if (text.length > 0) {
        $(".search").css("display", "block");
    }
}
