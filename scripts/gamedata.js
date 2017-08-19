function loadGameData(data) {
	for(var index in data) {
		var datum = data[index];
		var $section = $("<section/>")
			.html($("#contents .game-list template").html())
			.data("game-data", JSON.stringify(datum))
			.on("click", openModal)
			.appendTo("#contents .game-list");

		$section.find(".cover img").attr("src", datum["Thumbnail"]);
		$section.find(".summary .title").text(datum["Title"]);
		$section.find(".summary .creator").text(datum["Creator"]);

		function openModal() {
			var datum = JSON.parse($(this).data("game-data"));
			var $origin = $(".modal-origin[name=game-detail]");
			var $modal = $origin.get(0).open();

			var genres = datum["Genres"].join(", ");
			var platforms = datum["Platforms"].join(", ");

			$modal.find(".cover img").attr("src", datum["Thumbnail"]);
			$modal.find(".summary .title").text(datum["Title"]);
			$modal.find(".summary .creator").text(datum["Creator"]);
			$modal.find(".summary .genres").text(genres);
			$modal.find(".summary .platforms").text(platforms);
			$modal.find(".download").on("click", function() { download(datum); });

			loadOrbit($modal, datum);
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
				alert("이용중인 기기에서 지원하지 않는 콘텐츠입니다.");
		}

		function loadOrbit($modal, gamedata) {
			var data = new Array();
			if(gamedata["Images"].indexOf(',') == -1) {
				var datum = new Object();
				datum["ID"] = 0;
				datum["Image"] = "/images/dalchong.jpg";
				datum["Summary"] = "등록된 이미지가 없습니다.";
				datum["Actived"] = 1;
				data.push(datum);
			} else {
				var images = gamedata["Images"].split(',');
				for(var index in images) {
					var datum = new Object();
					datum["ID"] = index;
					datum["Image"] = images[index];
					datum["Actived"] = 1;
					data.push(datum);
				}
			}

			var orbit = $modal.find(".orbitArea").get(0);
			(Orbit).call(orbit);
			orbit.load(data);

			updateOrbitHeight(orbit);
			$(window).on("resize", function() { updateOrbitHeight(orbit); });
		}

		function updateOrbitHeight(orbit) {
			$(orbit).height($(orbit).width() * 0.56);
		}
	}
}
