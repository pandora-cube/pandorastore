$(document).ready(function() {
	(Orbit).call($("#topOrbit").get(0));

	updateOrbitHeight();
	$(window).on("resize", updateOrbitHeight);

	function updateOrbitHeight() {
		(function() {
			$(this).height($(this).find("ul.orbit").width() * 0.4);
		}).call($("#topOrbit").get(0));
	}
});

function loadTopOrbitData(data) {
	$("#topOrbit").get(0).load(data);
}
