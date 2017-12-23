$(document).ready(function onDocumentReady() {
    function onScroll() {
        var scrolltop = $(window).scrollTop();
        var $menuarea = $(".menuArea[class!=fixed]");
        var menutop = $menuarea.position().top;

        if (scrolltop > menutop && $(".menuArea.fixed").length === 0) {
            $menuarea.clone(true)
                .appendTo($menuarea.parent())
                .addClass("fixed")
                .attr("id", "")
                .find(".inner-menu")
                .css("display", "")
                .css("z-index", "");
        } else if (scrolltop < menutop) {
            $(".menuArea.fixed").remove();
        }
    }

    function showInnerMenu() {
        $(this).addClass("on");
    }
    function hideInnerMenu() {
        $(this).removeClass("on");
    }

    function close() {
        window.location.hash = "#_";
    }

    $(window).on("scroll", onScroll);
    $(".menuArea .menu > li")
        .hover(showInnerMenu, hideInnerMenu)
        .focusin(showInnerMenu)
        .focusout(hideInnerMenu);
    $(".menuArea .background").click(close);
});
