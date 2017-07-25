function loadGameData(data) {
	for(var datum of data) {
		var $section = $("<section/>")
			.html($("#contents .game-list cast").html())
			.on("click", openModal)
			.appendTo("#contents .game-list");

		$section.find(".cover img").attr("src", datum["Thumbnail"]);
		$section.find(".summary .title").text(datum["Title"]);
		$section.find(".summary .creator").text(datum["Creator"]);

		function openModal() {
			var $origin = $(".modal-origin[name=game-detail]");

			$origin.find(".cover img").attr("src", datum["Thumbnail"]);
			$origin.find(".summary .title").text(datum["Title"]);
			$origin.find(".summary .creator").text(datum["Creator"]);

			$origin.get(0).open();
		}
	}
}
