$(document).ready(function onDocumentReady() {
    function onScroll() {
        var scrolltop = $(window).scrollTop();
        var $menuarea = $(".menuArea[class!=fixed]");
        var menutop = $menuarea.position().top;

        if (scrolltop > menutop && $(".menuArea.fixed").length === 0) {
            $menuarea.clone(true)
                .appendTo($menuarea.parent())
                .addClass("fixed");
        } else if (scrolltop < menutop) {
            $(".menuArea.fixed").remove();
        }
    }

    $(window).on("scroll", onScroll);
});
