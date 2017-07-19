$(document).ready(function() {
	$(".orbitArea").each(function() {
		var orbit = $("<ul/>").addClass("orbit").appendTo(this);
		var orbitTimer;

		addButton("<", "left");
		addButton(">", "right");

		this.load = function(data) {
			applyData(data);
			applyImages();
			activeSlide(0, "slow");
		};

		this.stop = function() {
			clearTimeout(orbitTimer);
		};

		function addButton(text, direction) {
			var button = $("<button/>")
				.addClass(direction)
				.text(text)
				.appendTo(orbit);

			// 버튼 클릭 이벤트
			var index = null;
			if(direction == "left")
				index = -1;
			else if(direction == "right")
				index = -2;
			if(index != null)
				button.on("click", function() {
					activeSlide(index, "fast");
				});
		}

		function applyData(data) {
			for(var datum of data) {
				var slide = $("<li/>")
					.data("image", datum["Image"])
					.data("position", datum["Position"])
					.appendTo(orbit);

				var summary = datum["Summary"] || "";
				var description = datum["Description"] || "";
				var url = datum["URL"] || "";
				if(summary.length > 0 || description.length > 0) {
					var wrapper = $("<div/>").addClass("caption-wrapper").appendTo(slide);
					var caption = $("<div/>").addClass("caption").appendTo(wrapper);

					if(summary.length > 0)
						$("<div/>").addClass("summary").text(summary).appendTo(caption);
					if(description.length > 0)
						$("<div/>").addClass("description").text(description).appendTo(caption);
				}
				if(url.length > 0) {
					slide.on("click", { url: url }, function(e) {
						location.href = e.data.url;
					});
				}
			}
		}

		function applyImages() {
			$(orbit).find("li").each(function() {
				$(this).css("background-image", "url(\"" + $(this).data("image") + "\")");
				$(this).css("background-position", $(this).data("position"));
			});
		}

		function activeSlide(index, speed, interval) {
			interval = interval || 5000;
			clearTimeout(orbitTimer);

			var pre = $(orbit).find("li.active");
			var slide;
			if($(orbit).find("li").length == 0)
				return;
			else if(index == -1) { // 뒤로
				slide = pre.prev("li");
				if(slide.length == 0)
					slide = $(orbit).find("li").last();
			} else if(index == -2) { // 앞으로
				slide = pre.next("li");
				if(slide.length == 0)
					slide = $(orbit).find("li").first();
			} else if(index >= 0)
				slide = $(orbit).find("li").eq(index);
			else
				slide = $(orbit).find("li").first();

			slide.addClass("active");
			if(pre.length == 0) {
				slide.css("display", "list-item");
			} else {
				pre.removeClass("active");
				slide.css("z-index", 2);
				slide.fadeIn(speed, function() {
					pre.css("z-index", 0);
					pre.css("display", "none");
					slide.css("z-index", 1);
				});
			}

			// 타이머
			if(interval > 0) {
				orbitTimer = setTimeout(function() {
					activeSlide(-2, "slow", interval);
				}, interval);
			}
		}
	});
});
