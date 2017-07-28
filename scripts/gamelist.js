function loadGameData(data) {
	for(var index in data) {
		var datum = data[index];
		var $section = $("<section/>")
			.html($("#contents .game-list cast").html())
			.data("game-data", JSON.stringify(datum))
			.on("click", openModal)
			.appendTo("#contents .game-list");

		$section.find(".cover img").attr("src", datum["Thumbnail"]);
		$section.find(".summary .title").text(datum["Title"]);
		$section.find(".summary .creator").text(datum["Creator"]);

		function openModal() {
			var datum = JSON.parse($(this).data("game-data"));
			var $origin = $(".modal-origin[name=game-detail]");

			var categories = "";
			for(var c in datum["Categories"])
				categories += datum["Categories"][c] + ", ";
			categories = categories.substr(0, categories.length-2);

			$origin.find(".cover img").attr("src", datum["Thumbnail"]);
			$origin.find(".summary .title").text(datum["Title"]);
			$origin.find(".summary .creator").text(datum["Creator"]);
			$origin.find(".summary .categories").text(categories);

			$origin.find(".summary .download").off("click");
			$origin.find(".summary .download").on("click", function() { download(datum); });

			$origin.get(0).open();
		}

		function download(datum) {
			var columns = ["DownloadURL_Android", "DownloadURL_iOS", "DownloadURL"];
			var os = getOSName();

			if(os == "Android" && datum["DownloadURL_Android"].length != 0)
				window.open(datum["DownloadURL_Android"]);
			else if(os == "Mac/iOS" && datum["DownloadURL_iOS"].length != 0)
				window.open(datum["DownloadURL_iOS"]);
			else if(datum["DownloadURL"].length != 0)
				window.open(datum["DownloadURL"]);
			else
				alert("파일이 등록되지 않았습니다.");
		}
	}
}
