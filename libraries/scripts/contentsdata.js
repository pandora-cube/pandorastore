function loadContentsData(data, categoryName, tags) {
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

    function loadSlide($modal, contentsData) {
        var $slideWrapper = $modal.find(".slideArea .slideWrapper");
        var images = contentsData.Images;
        var i;

        if (images.length === 0) {
            // 콘텐츠 이미지가 없을 시
            $("<img>")
                .appendTo($("<div>")
                    .appendTo($slideWrapper)
                    .addClass("image-wrapper"))
                .addClass("align-middle")
                .attr("src", "/images/dalchong.jpg")
                .attr("title", "등록된 이미지가 없습니다.");

            $slideWrapper.bxSlider({
                touchEnabled: false,
                pager: false,
                captions: true,
            });
        } else {
            // 콘텐츠 이미지가 있을 시
            for (i = 0; i < images.length; i++) {
                $("<img>")
                    .appendTo($("<div>")
                        .appendTo($slideWrapper)
                        .addClass("image-wrapper"))
                    .addClass("align-middle")
                    .attr("src", images[i]);
            }

            $slideWrapper.bxSlider({
                auto: true,
                autoControls: true,
                stopAutoOnClick: true,
            });
        }
    }

    function openModal() {
        var datum = data[parseInt($(this).data("contents-index"), 10)];
        var $modal = Modal("contents-detail", "/contents/detail");
        var genres = datum.Genres.join(", ");
        var platforms = datum.Platforms.join(", ");
        var originalTitle = $("title").text();
        var i;
        var url;
        var text;
        var downloadData = [
            ["DownloadURL_Android", "Android"],
            ["DownloadURL_iOS", "iOS"],
            ["DownloadURL", "기타OS"],
        ];

        $modal.data("identifier", datum.Identifier);
        $modal.get(0).onPrepared = function onModalPrepared() {
            $("title").text(datum.Title + " - " + originalTitle);

            $modal.find(".summary .title").text(datum.Title);
            $modal.find(".summary .creator").text(datum.Creator);
            $modal.find(".summary .genres").text(genres);
            $modal.find(".summary .platforms").text(platforms);
            $modal.find(".reviewArea .write input[name=content]").val(datum.Identifier);

            for (i = 0; i < downloadData.length; i++) {
                url = datum[downloadData[i][0]];
                text = downloadData[i][1];

                if (url.length > 0) {
                    if (url.indexOf("http://") !== 0 && url.indexOf("https://") !== 0) {
                        url = "/contents/" + datum.Identifier + "/" + url;
                    }

                    $("<a>")
                        .text(text)
                        .attr("href", url)
                        .appendTo($modal.find(".download"));
                }
            }

            $modal.get(0).onClose = function onModalClose() {
                window.location.hash = "#_";
                $("title").text(originalTitle);
            };

            $modal.get(0).open();

            loadThumbnail($modal, datum);
            loadSlide($modal, datum);
        };
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
