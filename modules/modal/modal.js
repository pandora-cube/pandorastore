$(document).ready(function() {
	$(".modal-origin").each(Modal);
});

function Modal() {
	var origin = this;

	this.open = function(closebutton, animation) {
		closebutton = closebutton || true;
		animation = animation || true;
		$("body").css("overflow", "hidden");
		return createModal(closebutton, animation);
	};

	this.close = function() {
		$("body").css("overflow", "auto");
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
				.html("&#120684;")
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
