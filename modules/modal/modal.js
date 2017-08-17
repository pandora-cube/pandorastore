$(document).ready(function() {
	$(".modal-origin").each(Modal);
});

function Modal() {
	var origin = this;

	this.open = function(closebutton) {
		closebutton = closebutton || true;
		createModal(closebutton);
		$("body").css("overflow", "hidden");
	};

	this.close = function() {
		destroyModal();
		$("body").css("overflow", "auto");
	};

	function createModal(closebutton) {
		var $area = $("<div/>")
			.attr("id", $(origin).attr("name"))
			.addClass("modalArea")
			.on("click", function(e) {
				if(e.target != this) return;
				origin.close();
			})
			.prependTo("body");

		var $modal = $(origin).clone(true)
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
	}

	function destroyModal() {
		$(".modalArea#"+$(origin).attr("name"))
			.remove();
	}
}
