function Modal() {
    this.onOpen = function onModalOpen() { };
    this.onClose = function onModalClose() { };
}

function ModalOrigin() {
    var origin = this;
    var $area;
    var $modal;

    function onCloseButtonClicked(e) {
        if (e.target !== this) return;
        origin.close();
    }

    function createModal(closebutton) {
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
            .prependTo($area)
            .each(Modal);

        if (closebutton) {
            $("<button/>")
                .addClass("closebutton")
                .on("click", onCloseButtonClicked)
                .html("&#10006;")
                .prependTo($modal);
        }

        $modal.get(0).onOpen();

        return $area;
    }

    function destroyModal() {
        $modal.get(0).onClose();
        $area.remove();
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
    $(".modal-origin").each(ModalOrigin);
});
