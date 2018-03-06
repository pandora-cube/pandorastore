$(document).ready(function onDocumentReady() {
    $(".open-search").click(function openSearchForm() {
        $(".search").slideToggle();
    });

    // 사용자 메뉴
    $(".accounts-menu-button").click(function openUserMenu() {
        var $menu = $(this).siblings(".accounts-menu");
        if ($menu.css("display") !== "block") { // 사용자메뉴가 닫혀 있는 경우
            $(".accounts-menu-button.closed").hide();
            $(".accounts-menu-button.opened").show();
            $menu.fadeIn();
        }
    });
    $(document).mouseup(function closeUserMenu(e) {
        var $menu = $(".accounts-menu");
        if ($menu.css("display") === "block" && $menu.has(e.target).length === 0) { // 열려 있는 사용자 메뉴 바깥을 클릭한 경우
            $(".accounts-menu-button.closed").show();
            $(".accounts-menu-button.opened").hide();
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
