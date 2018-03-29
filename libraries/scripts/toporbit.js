function loadTopOrbitData(data) {
    var $slideWrapper = $("header .slideArea .slideWrapper");
    var $imageWrapper;
    var i;

    for (i = 0; i < data.length; i++) {
        if (data[i].URL.length > 0) {
            // URL이 있는 경우 이미지 영역을 A 태그로 만듬
            $imageWrapper = $("<a>")
                .addClass("image-wrapper")
                .attr("href", data[i].URL);
            // 외부 링크인 경우
            if (data[i].URL.indexOf("http://") === 0 || data[i].URL.indexOf("https://") === 0) {
                $imageWrapper.attr("target", "_blank");
            }
        } else {
            // URL이 없는 경우 이미지 영역을 DIV 태그로 만듬
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
