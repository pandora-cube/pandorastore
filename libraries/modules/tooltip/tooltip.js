$(document).ready(function onDocumentReady() {
    // 툴팁 활성화
    function activateTooltip() {
        $(this).children(".tooltip")
            .addClass("on");
    }

    // 툴팁 비활성화
    function disableTooltip() {
        $(this).children(".tooltip")
            .removeClass("on");
    }

    // DOM이 변경될 때
    $("body").on("DOMSubtreeModified", function onDocumentModified() {
        // 모든 .tooltip-wrapper 엘리먼트에 수행
        $(".tooltip-wrapper").each(function addTooltipEvent() {
            var i;
            var events = $._data(this, "events"); // 바인딩된 이벤트들
            var activateEvents = ["focus", "mouseover"]; // 활성화 이벤트 이름 배열
            var disableEvents = ["focusout", "mouseout"]; // 비활성화 이벤트 이름 배열

            // 활성화 이벤트 바인딩
            for (i = 0; i < activateEvents.length; i++) {
                if (events === undefined // 바인딩된 이벤트가 없는 경우
                || events[activateEvents[i]] === undefined) { // 활성화 이벤트가 바인딩되지 않은 경우
                    // 이벤트 바인딩
                    $(this).on(activateEvents[i], activateTooltip);
                }
            }

            // 비활성화 이벤트 바인딩
            for (i = 0; i < disableEvents.length; i++) {
                if (events === undefined // 바인딩된 이벤트가 없는 경우
                || events[disableEvents[i]] === undefined) { // 비활성화 이벤트가 바인딩되지 않은 경우
                    // 이벤트 바인딩
                    $(this).on(disableEvents[i], disableTooltip);
                }
            }
        });
    });
});
