$(document).ready(function onDocumentReady() {
    $(".open-search").click(function openSearchForm() {
        $(".search").slideToggle();
    });

    // 사용자 메뉴
    $(".user-menu-button").click(function openUserMenu() {
        $(this).siblings(".user-menu").fadeToggle();
    });
    $(document).mouseup(function closeUserMenu(e) {
        var $menu = $(".user-menu");
        if ($menu.css("display") === "block" // 메뉴가 열려 있는 경우
            && $menu.has(e.target).length === 0 // 메뉴 바깥을 클릭한 경우
            && $(".user-menu-button").has(e.target).length === 0) { // 메뉴 버튼 바깥을 클릭한 경우
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
