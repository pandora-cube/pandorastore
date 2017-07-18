function loadGameData(data) {
	for(var datum of data) {
		var section = $("<section/>")
			.html($("#contents .list cast").html())
			.attr("game-id", datum["ID"])
			.appendTo("#contents .list");
		section.find(".cover img").attr("src", datum["Thumbnail"]);
		section.find(".details .title").text(datum["Title"]);
		section.find(".details .subtitle").text(datum["Creator"]);
	}
}
