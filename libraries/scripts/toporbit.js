function loadTopOrbitData(data) {
    var $slideWrapper = $("header .slideArea .slideWrapper");
    var i;

    for (i = 0; i < data.length; i++) {
        $("<img>")
            .appendTo($("<div>")
                .appendTo($slideWrapper)
                .addClass("imageWrapper"))
            .addClass("align-" + data[i].Position)
            .attr("src", data[i].Image)
            .attr("title", data[i].Summary)
            .attr("alt", data[i].Description);
    }

    $slideWrapper.bxSlider({
        auto: true,
        autoControls: true,
        stopAutoOnClick: true,
        captions: true,
    });
}
