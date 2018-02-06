function loadContentsData(data, categoryName, tags) {
    function download(id) {
        $.get("/contents_download", {
            id: id,
        }).done(function onSuccess(url) {
            if (url.length !== 0) {
                window.open(url);
            } else {
                alert("이용중인 기기에서 지원하지 않는 콘텐츠입니다.");
            }
        }).fail(function onFail() {
            alert("오류가 발생하여 콘텐츠를 내려받을 수 없습니다.");
        });
    }

    function loadThumbnail($item, datum) {
        $.ajax({
            type: "HEAD",
            url: datum.Thumbnail,
            success: function onSuccess() {
                $item.find(".cover img")
                    .attr("src", datum.Thumbnail)
                    .attr("alt", datum.Title + " 썸네일 이미지");
            },
            error: function onError() {
                $item.find(".cover img")
                    .attr("src", "/images/logo_dark.png")
                    .attr("alt", datum.Title + " 썸네일 이미지 없음");
            },
        });
    }

    function loadOrbit($modal, contentsData) {
        var orbitData = [];
        var datum;
        var images;
        var orbit;
        var i;

        if (contentsData.Images.length === 0) {
            datum = {};
            datum.ID = 0;
            datum.Image = "/images/dalchong.jpg";
            datum.Summary = "등록된 이미지가 없습니다.";
            datum.Actived = 1;
            orbitData.push(datum);
        } else {
            images = contentsData.Images;
            for (i = 0; i < images.length; i++) {
                datum = {};
                datum.ID = i;
                datum.Image = images[i];
                datum.Actived = 1;
                orbitData.push(datum);
            }
        }

        orbit = $modal.find(".orbitArea").get(0);
        (Orbit).call(orbit);
        orbit.load(orbitData);

        updateOrbitHeight(orbit);
        $(window).on("resize", function () { updateOrbitHeight(orbit); });
    }

    function openModal() {
        var datum = data[parseInt($(this).data("contents-index"), 10)];
        var $origin = $(".modal-origin[name=contents-detail]");
        var $modal = $origin.get(0).open().children(".modal");
        var genres = datum.Genres.join(", ");
        var platforms = datum.Platforms.join(", ");
        var closecallback;

        $modal.find(".summary .title").text(datum.Title);
        $modal.find(".summary .creator").text(datum.Creator);
        $modal.find(".summary .genres").text(genres);
        $modal.find(".summary .platforms").text(platforms);
        $modal.find(".download").on("click", function () { download(datum.ID); });

        closecallback = $modal.get(0).onClose;
        $modal.get(0).onClose = function onModalClose() {
            window.location.hash = "#_";
            closecallback();
        };

        loadThumbnail($modal, datum);
        loadOrbit($modal, datum);
    }

    function updateOrbitHeight(orbit) {
        $(orbit).height($(orbit).width() * 0.56);
    }

    function loadContentsItem($list, index, datum) {
        var $item;

        $item = $("<a/>")
            .html($("#contents template[name=contents-item]").html())
            .addClass("contents-item")
            .attr("id", "contents-anchor-" + datum.Identifier)
            .attr("href", "#contents=" + datum.Identifier)
            .data("contents-index", index)
            .on("click", openModal)
            .appendTo($list);

        $item.find(".summary .title").text(datum.Title);
        $item.find(".summary .creator").text(datum.Creator);

        loadThumbnail($item, datum);
    }

    function loadContentsList() {
        var $list;
        var i;
        var j;

        if (categoryName.length > 0) {
            $("<h2/>")
                .text(categoryName)
                .appendTo("#contents");
            $list = $("<section/>")
                .addClass("contents-list")
                .appendTo("#contents");

            for (i = 0; i < data.length; i += 1) {
                loadContentsItem($list, i, data[i]);
            }
        } else {
            for (i = 0; i < tags.length; i += 1) {
                $("<h2/>")
                    .text(tags[i].Name)
                    .appendTo("#contents");
                $("<section/>")
                    .attr("id", "tag-" + tags[i].ID)
                    .addClass("contents-list")
                    .appendTo("#contents");
            }

            for (i = 0; i < data.length; i += 1) {
                for (j = 0; j < data[i].TagsID.length; j += 1) {
                    $list = $("#tag-" + data[i].TagsID[j]);
                    if ($list.length > 0) {
                        loadContentsItem($list, i, data[i]);
                    }
                }
            }
        }
    }

    function checkLocationHash() {
        var hash = window.location.hash;
        var identifier;
        var $anchor;

        if (hash.indexOf("#contents=") === 0) {
            identifier = hash.split("#contents=")[1];
            $anchor = $("a#contents-anchor-" + identifier);
            if ($anchor.length > 0) {
                $anchor.click();
            }
        }
    }

    loadContentsList();
    checkLocationHash();
}
