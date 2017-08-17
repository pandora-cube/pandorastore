$(document).ready(function() {
	$(".modal-origin").each(Modal);
});

function Modal() {
	var origin = this;

	this.open = function(closebutton, animation) {
		closebutton = closebutton || true;
		animation = animation || true;

		var scrollTop = $(window).scrollTop();
		var height = $(document).height();
		$(this).data("scrollTop", scrollTop);
		$("html, body").addClass("notScroll");
		$("body")
			.css("top", -scrollTop)
			.css("height", height);

		return createModal(closebutton, animation);
	};

	this.close = function() {
		$("body")
			.css("top", 0)
			.css("height", "auto");
		$("html, body").removeClass("notScroll");
		$(window).scrollTop($(this).data("scrollTop"));

		destroyModal();
	};

	function createModal(closebutton, animation) {
		var $area = $("<div/>")
			.attr("id", $(origin).attr("name"))
			.addClass("modalArea")
			.on("click", function(e) {
				if(e.target != this) return;
				origin.close();
			})
			.prependTo("body");

		var $modal = $("<div/>")
			.html($(origin).html())
			.removeAttr("name")
			.removeClass("modal-origin")
			.addClass("modal")
			.prependTo($area);

		if(closebutton)
			$("<a/>")
				.attr("href", "javascript:;")
				.addClass("closebutton")
				.on("click", function(e) {
					if(e.target != this) return;
					origin.close();
				})
				.html("&#10006;")
				.prependTo($modal);

		if(animation) {
			$modal.hide().slideDown("fast");
		}

		return $area;
	}

	function destroyModal() {
		$(".modalArea#"+$(origin).attr("name"))
			.remove();
	}
}
