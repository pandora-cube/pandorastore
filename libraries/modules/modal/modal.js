/*
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
        var originName = origin.getAttribute("name");

        if ($("#" + originName).length > 0) {
            origin.close();
        }

        $area = $("<div/>")
            .attr("id", originName)
            .addClass("modalArea")
            .on("click", onCloseButtonClicked)
            .appendTo("body");

        $modal = $("<div/>")
            .html(origin.innerHTML)
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
*/

function Modal(name, url) {
    var $area;
    var $modal;

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
        if ($("#" + name).length > 0) {
            $("#" + name).get(0).close();
        }

        $area
            .appendTo("body")
            .fadeIn("slow")
            .get(0).onOpen();
    }

    function destroyModal() {
        $area.get(0).onClose();
        $area.remove();
    }

    function createArea() {
        $area = $("<div>")
            .attr("id", name)
            .addClass("modalArea")
            .on("click", onCloseButtonClicked)
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
