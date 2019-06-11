function Modal(name, url) {
    var $bodyWrapper;
    var $area;
    var $modal;
    var $topButtonsContainer;
    var $topButtons = [];
    var scrollTop;

    function initializeModal(openModal_, destroyModal_, addTopButton_) {
        this.onReady = $.Event("ready");
        this.onOpen = $.Event("onOpen");
        this.onClose = $.Event("close");

        $.fn.extend({
            open: openModal_,
            close: destroyModal_,
            addTopButton: addTopButton_,
        });
    }

    function onCloseButtonClicked(e) {
        if (e.target !== this) return;
        $area.close();
    }

    function createModal(html) {
        var i;

        $modal = $("<div>")
            .html(html)
            .addClass("modal")
            .prependTo($area);

        $topButtonsContainer = $("<div>")
            .addClass("top-buttons")
            .prependTo($modal);

        for (i = 0; i < $topButtons.length; i++) {
            $topButtons[i].appendTo($topButtonsContainer);
        }

        $topButtonsContainer
            .append($("<button>")
                .addClass("closebutton")
                .on("click", onCloseButtonClicked)
                .append($("<i>")
                    .addClass("material-icons")
                    .html("close")));

        return $modal;
    }

    function openModal(html) {
        $area
            .fadeIn("slow")
            .trigger($area.get(0).onOpen);

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

        $area.trigger($area.get(0).onClose);
        $area.remove();
    }

    function addTopButton() {
        var $button = $("<button>");

        $topButtons.push($button);

        return $button;
    }

    function createArea() {
        if ($("#" + name).length > 0) {
            $("#" + name).close();
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
                initializeModal.call(this, openModal, destroyModal, addTopButton);
            });

        return $area;
    }

    createArea();
    $.get(url).done(function ready(html) {
        createModal(html);
        $area.trigger($area.get(0).onReady);
    });

    return $area;
}
