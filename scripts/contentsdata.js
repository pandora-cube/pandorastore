function loadContentsData(data) {
    function download(id) {
        console.log(id);
        $.get("/functions/get_download_url.php", {
            id,
        }).done((url) => {
            if (url.length !== 0) {
                window.open(url);
            } else {
                alert("이용중인 기기에서 지원하지 않는 콘텐츠입니다.");
            }
        }).fail(() => {
            alert("이용중인 기기에서 지원하지 않는 콘텐츠입니다.");
        });
    }

    function loadOrbit($modal, contentsData) {
        const orbitData = [];
        if (contentsData.Images.length === 0) {
            const datum = {};
            datum.ID = 0;
            datum.Image = "/images/dalchong.jpg";
            datum.Summary = "등록된 이미지가 없습니다.";
            datum.Actived = 1;
            orbitData.push(datum);
        } else {
            const images = contentsData.Images;
            for (let i = 0; i < images.length; i++) {
                const datum = {};
                datum.ID = i;
                datum.Image = images[i];
                datum.Actived = 1;
                orbitData.push(datum);
            }
        }

        const orbit = $modal.find(".orbitArea").get(0);
        (Orbit).call(orbit);
        orbit.load(orbitData);

        updateOrbitHeight(orbit);
        $(window).on("resize", () => updateOrbitHeight(orbit));
    }

    function openModal() {
        const datum = data[parseInt($(this).data("contents-index"), 10)];
        const $origin = $(".modal-origin[name=contents-detail]");
        const $modal = $origin.get(0).open();
        const genres = datum.Genres.join(", ");
        const platforms = datum.Platforms.join(", ");

        $modal.find(".cover img").attr("src", datum.Thumbnail);
        $modal.find(".summary .title").text(datum.Title);
        $modal.find(".summary .creator").text(datum.Creator);
        $modal.find(".summary .genres").text(genres);
        $modal.find(".summary .platforms").text(platforms);
        $modal.find(".download").on("click", () => download(datum.ID));

        loadOrbit($modal, datum);
    }

    function updateOrbitHeight(orbit) {
        $(orbit).height($(orbit).width() * 0.56);
    }

    for (let i = 0; i < data.length; i += 1) {
        const datum = data[i];
        const $section = $("<section/>")
            .html($("#contents .contents-list template").html())
            .data("contents-index", i)
            .on("click", openModal)
            .appendTo("#contents .contents-list");

        $section.find(".cover img").attr("src", datum.Thumbnail);
        $section.find(".summary .title").text(datum.Title);
        $section.find(".summary .creator").text(datum.Creator);
    }
}
