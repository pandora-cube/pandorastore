$(document).ready(function() {
	$(window).on("scroll", onScroll);

	$(".menuArea").hover(onMouseEnter, onMouseLeave);
	$(".menuArea .menu > li").hover(onMouseEnter, onMouseLeave);

	function onScroll() {
		var scrolltop = $(window).scrollTop();
		var $menuarea = $(".menuArea[class!=fixed]");
		var menutop = $menuarea.position().top;

		if(scrolltop > menutop && $(".menuArea.fixed").length == 0) {
			$menuarea
				.removeClass("enabled")
				.find("li, .inner-menu")
					.removeClass("enabled");
			$menuarea.clone(true)
				.appendTo($menuarea.parent())
				.addClass("fixed");
		} else if(scrolltop < menutop) {
			$(".menuArea.fixed").remove();
		}
	}

	function onMouseEnter(e) {
		$(e.currentTarget).addClass("enabled");
		$(e.currentTarget).children(".inner-menu")
			.addClass("enabled");
	}

	function onMouseLeave(e) {
		$(e.currentTarget).removeClass("enabled");
		$(e.currentTarget).children(".inner-menu")
			.removeClass("enabled");
	}
});
