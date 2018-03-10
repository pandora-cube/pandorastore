function loadTopOrbitData(data) {
    var $slideWrapper = $("header .slideArea .slideWrapper");
    var $imageWrapper;
    var i;

    for (i = 0; i < data.length; i++) {
        if (data[i].URL.length > 0) {
            $imageWrapper = $("<a>")
                .addClass("image-wrapper")
                .attr("href", data[i].URL)
                .attr("target", "_blank");
        } else {
            $imageWrapper = $("<div>")
                .addClass("image-wrapper");
        }

        $slideWrapper.append(
            $imageWrapper.append(
                $("<img>")
                    .addClass("align-" + data[i].Position)
                    .attr("src", data[i].Image)
                    .attr("title", data[i].Summary)
                    .attr("alt", data[i].Description))); // ALT 적용되지 않고 있음
    }

    $slideWrapper.bxSlider({
        auto: true,
        autoControls: true,
        stopAutoOnClick: true,
        captions: true,
    });
}
