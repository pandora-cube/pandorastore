function Modal() {
    var origin = this;

    function onCloseButtonClicked(e) {
        if (e.target !== this) return;
        origin.close();
    }

    function createModal(closebutton) {
        var $area;
        var $modal;

        $area = $("<div/>")
            .attr("id", $(origin).attr("name"))
            .addClass("modalArea")
            .on("click", onCloseButtonClicked)
            .prependTo("body");

        $modal = $("<div/>")
            .html($(origin).html())
            .removeAttr("name")
            .removeClass("modal-origin")
            .addClass("modal")
            .fadeIn("slow")
            .prependTo($area);

        if (closebutton) {
            $("<button/>")
                .addClass("closebutton")
                .on("click", onCloseButtonClicked)
                .html("&#10006;")
                .prependTo($modal);
        }

        return $area;
    }

    function destroyModal() {
        $(".modalArea#" + $(origin).attr("name")).remove();
    }

    this.open = function openModal(closebutton_) {
        var closebutton = closebutton_ || true;
        var scrollTop = $(window).scrollTop();
        var height = $(document).height();

        $(this).data("scrollTop", scrollTop);
        $("html, body").addClass("notScroll");
        $("body")
            .css("top", -scrollTop)
            .css("height", height);

        return createModal(closebutton);
    };

    this.close = function closeModal() {
        $("body")
            .css("top", 0)
            .css("height", "auto");
        $("html, body").removeClass("notScroll");
        $(window).scrollTop($(this).data("scrollTop"));

        destroyModal();
    };
}

$(document).ready(function onDocumentReady() {
    $(".modal-origin").each(Modal);
});
