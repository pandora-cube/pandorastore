$(document).ready(function() {
	var orbit = [
		{
			image: "images/dalchong.jpg", position: "middle",
			summary: "이 영역은 제목입니다.", description: "이 영역에는 설명을 기입하세요. 물론 생략할 수도 있습니다."
		}, {
			image: "images/sejongduck.jpg", position: "bottom",
			summary: "설명을 생략하면 이렇게 보여집니다."
		}, {
			image: "images/coex.jpg", position: "bottom"
		}
	];

	setHeaderOrbitHeight();
	$(window).on("resize", setHeaderOrbitHeight);

	$("header .orbitArea").each(function() { this.load(orbit) });
});

function setHeaderOrbitHeight() {
	$("header .orbitArea").each(function() {
		$(this).height($(this).find("ul.orbit").width() * 0.4);
	});
}
