$(document).ready(function() {
	updateOrbitHeight();
	$(window).on("resize", updateOrbitHeight);

	function updateOrbitHeight() {
		$("header .orbitArea").each(function() {
			$(this).height($(this).find("ul.orbit").width() * 0.4);
		});
	}
});

function loadOrbitData(data) {
	$("header .orbitArea").each(function() {
		this.load(<?=json_encode($orbit)?>);
	});
}
