$(document).ready(function() {
	updateOrbitHeight();
	$(window).on("resize", updateOrbitHeight);

	function updateOrbitHeight() {
		$("#topOrbit").each(function() {
			$(this).height($(this).find("ul.orbit").width() * 0.4);
		});
	}
});

function loadTopOrbitData(data) {
	$("#topOrbit").each(function() {
		this.load(data);
	});
}
