function AutoComplete() {
    var $ac = $(this);
    var $dest = $("#" + $(this).data("for"));

    function onItemClicked() {
        $dest.val($(this).data("value"));
        $ac.clear();
    }

    function adjustItemPadding() {
        var left = $dest.css("padding-left");
        var right = $dest.css("padding-right");

        $(this).css({
            paddingLeft: left,
            paddingRight: right,
        });
    }

    this.clear = function clear() {
        $ac.empty();
        this.hide();
        return this;
    };

    this.show = function show() {
        if ($ac.children(".ac-item").length === 0) {
            return this;
        }

        $ac.width($dest.outerWidth() - 2);
        $ac.children(".ac-item").each(adjustItemPadding);

        $ac.addClass("on");
        return this;
    };

    this.hide = function hide() {
        $ac.removeClass("on");
        return this;
    };

    this.addItem = function addItem(text, value) {
        $ac.append($("<li>")
            .addClass("ac-item")
            .on("click", onItemClicked)
            .text(text)
            .data("value", value));
        return this;
    };

    function constructor() {
        var ac = $ac.get(0);

        $.fn.extend({
            clear: ac.clear,
            show: ac.show,
            hide: ac.hide,
            addItem: ac.addItem,
        });
    }

    constructor();
}
