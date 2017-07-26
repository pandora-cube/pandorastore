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

			var categories = "";
			for(var c of datum["Categories"])
				categories += c + ", ";
			categories = categories.substr(0, categories.length-2);

			$origin.find(".cover img").attr("src", datum["Thumbnail"]);
			$origin.find(".summary .title").text(datum["Title"]);
			$origin.find(".summary .creator").text(datum["Creator"]);
			$origin.find(".summary .categories").text(categories);

			$origin.get(0).open();
		}
	}
}
