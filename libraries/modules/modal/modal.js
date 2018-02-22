function Modal(name, url) {
    var $bodyWrapper;
    var $area;
    var $modal;
    var scrollTop;

    function ModalInner(openModal_, destroyModal_) {
        this.onPrepared = function onModalPrepared() { };
        this.onOpen = function onModalOpen() { };
        this.onClose = function onModalClose() { };

        this.open = function open() {
            openModal_();
        };

        this.close = function close() {
            destroyModal_();
        };
    }

    function onCloseButtonClicked(e) {
        if (e.target !== this) return;
        $area.get(0).close();
    }

    function createModal(html) {
        $modal = $("<div>")
            .html(html)
            .addClass("modal")
            .prependTo($area);

        $("<button>")
            .addClass("closebutton")
            .on("click", onCloseButtonClicked)
            .html("&#10006;")
            .prependTo($modal);

        return $modal;
    }

    function openModal(html) {
        $area
            .fadeIn("slow")
            .get(0).onOpen();

        scrollTop = window.pageYOffset;
        $("html, body").addClass("scrollLock");
        $bodyWrapper.css("top", -scrollTop);
    }

    function destroyModal() {
        $("html, body").removeClass("scrollLock");
        window.scrollTo(0, scrollTop);

        /*
        $bodyWrapper.children()
            .prependTo("body");
        $bodyWrapper.remove();
        */
        $bodyWrapper.css("top", "");

        $area.get(0).onClose();
        $area.remove();
    }

    function createArea() {
        if ($("#" + name).length > 0) {
            $("#" + name).get(0).close();
        }

        if ($(".body-wrapper").length === 0) {
            $bodyWrapper = $("<div>")
                .addClass("body-wrapper")
                .prependTo("body");
            $("body > *").not($bodyWrapper).not(".modalArea")
                .prependTo($bodyWrapper);
        } else {
            $bodyWrapper = $(".body-wrapper");
        }

        $area = $("<div>")
            .attr("id", name)
            .addClass("modalArea")
            .on("click", onCloseButtonClicked)
            .appendTo("body")
            .each(function applyInnerClass() {
                ModalInner.call(this, openModal, destroyModal);
            });

        return $area;
    }

    createArea();
    $.get(url).done(function prepare(html) {
        createModal(html);
        $area.get(0).onPrepared();
    });

    return $area;
}
