$(document).ready(function onDocumentReady() {
    function onScroll() {
        var scrolltop = $(window).scrollTop();
        var $menuarea = $(".menuArea[class!=fixed]");
        var menutop = $menuarea.position().top;

        if (scrolltop > menutop && $(".menuArea.fixed").length === 0) {
            $menuarea.clone(true)
                .appendTo($menuarea.parent())
                .addClass("fixed")
                .find(".inner-menu")
                .css("display", "")
                .css("z-index", "");
        } else if (scrolltop < menutop) {
            $(".menuArea.fixed").remove();
        }
    }

    function showInnerMenu() {
        $(this).children(".inner-menu")
            .slideDown(400);
    }
    function hideInnerMenu() {
        $(this).children(".inner-menu")
            .css("z-index", 1000)
            .slideUp(400, function () {
                $(this).css("z-index", "");
            });
    }

    $(window).on("scroll", onScroll);
    $(".menuArea .menu > li").hover(showInnerMenu, hideInnerMenu);
});
