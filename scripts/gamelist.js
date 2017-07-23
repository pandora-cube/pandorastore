function loadGameData(data) {
	for(var datum of data) {
		var $section = $("<section/>")
			.html($("#contents .game-list cast").html())
			.data("game-id", datum["ID"])
			.appendTo("#contents .game-list");

		$section.find(".cover img").attr("src", datum["Thumbnail"]);
		$section.find(".details .title").text(datum["Title"]);
		$section.find(".details .subtitle").text(datum["Creator"]);
	}
}
