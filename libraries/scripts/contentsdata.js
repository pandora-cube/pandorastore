function loadContentsData(data, categoryName, categoryDescription, tags) {
    function loadContentsItem($list, index, datum) {
        var $item;

        $item = $("<a/>")
            .html($("#contents template[name=contents-item]").html())
            .addClass("contents-item")
            .attr("id", "contents-anchor-" + datum.Identifier)
            .attr("href", "#contents=" + datum.Identifier)
            .data("contents-index", index)
            .appendTo($list);

        $item.find(".cover img")
            .attr("src", datum.Thumbnail)
            .attr("alt", datum.ThumbnailAlt);

        $item.find(".summary .title").text(datum.Title);
        $item.find(".summary .creator").text(datum.Creator);
    }

    function addContentsList(name, description, ID, filtered) {
        var $name = $("<div>");
        var $list = $("<section>");

        $("#contents")
            .append($name
                .addClass("category-name")
                .append($("<h2>")
                    .text(name))
                .append($("<button>")
                    .addClass("tooltip-wrapper")
                    .addClass("tooltip-icon")
                    .prop("hidden", (description.length === 0))
                    .append($("<i>")
                        .addClass("material-icons")
                        .html("&#xE88E;"))
                    .append($("<span>")
                        .addClass("tooltip")
                        .text(description)))
                .append($("<a>")
                    .prop("hidden", (ID.length === 0))
                    .attr("href", "/category/" + ID)
                    .addClass("show-all")
                    .append($("<span>")
                        .text("모두 보기"))))
            .append($list
                .addClass("contents-list"));

        if (filtered === 0) {
            $list.addClass("row");
        }

        return $list;
    }

    function loadContentsList() {
        var $list;
        var filtered;
        var i;
        var j;

        filtered = parseInt($("#filtered").val(), 10);

        if (categoryName.length > 0) {
            $list = addContentsList(categoryName, categoryDescription, "", filtered);

            for (i = 0; i < data.length; i++) {
                loadContentsItem($list, i, data[i]);
            }
        } else {
            for (i = 0; i < tags.length; i++) {
                addContentsList(tags[i].Name, tags[i].Description, "T" + tags[i].ID, filtered)
                    .attr("id", "tag-" + tags[i].ID);
            }

            for (i = 0; i < data.length; i++) {
                for (j = 0; j < data[i].TagsID.length; j++) {
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

        if (hash.indexOf("#contents=") === 0) {
            identifier = hash.split("#contents=")[1];
            Modal("contents-detail", "/contents/detail?identifier=" + identifier).open();
        } else if ($("#contents-detail").length > 0) {
            $("#contents-detail").close();
        }
    }

    loadContentsList();
    checkLocationHash();
    window.addEventListener("hashchange", checkLocationHash);
}
