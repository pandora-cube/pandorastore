function loadGameData(data) {
	for(var datum of data) {
		var section = $("<section/>")
			.appendTo("#contents .list")
			.html($("#contents .list cast").html());
		section.find(".cover img").attr("src", datum["Thumbnail"]);
		section.find(".details .title").text(datum["Title"]);
		section.find(".details .subtitle").text(datum["Creator"]);
	}
}
