$(document).ready(function onDocumentReady() {
    function updateOrbitHeight() {
        (function updateTopOrbitHeight() {
            $(this).height($(this).find("ul.orbit").width() * 0.4);
        }).call($("#topOrbit").get(0));
    }

    (Orbit).call($("#topOrbit").get(0));

    updateOrbitHeight();
    $(window).on("resize", updateOrbitHeight);
});

function loadTopOrbitData(data) {
    $("#topOrbit").get(0).load(data);
}
