$(document).ready(function onDocumentReady() {
    function adjustTooltipOffset(wrapper) {
        var $tooltip = $(wrapper).children(".tooltip"); // 툴팁 선택자
        var documentWidth = document.body.clientWidth; // 문서 폭
        var wrapperLeft = $(wrapper).offset().left; // 툴팁 위치 (left)
        var offsetPer = (wrapperLeft / documentWidth) * 100; // 문서 폭 대비 툴팁 위치

        /* 툴팁 위치 판별
         * ~ 40vw: 왼쪽에 위치
         * 40vw ~ 60vw: 중앙에 위치
         * 60vw ~: 오른쪽에 위치
         */
        if (offsetPer < 40.0) { // 툴팁이 왼쪽에 위치한 경우
            // 툴팁을 오른쪽으로 전개
            $tooltip
                .removeClass("left middle")
                .css("max-width", (documentWidth - wrapperLeft) + "px");
        } else if (offsetPer < 60.0) { // 툴팁이 중앙에 위치한 경우
            // 툴팁을 중앙으로 전개
            $tooltip
                .removeClass("left")
                .addClass("middle")
                .css("max-width", documentWidth + "px");
        } else { // 툴팁이 오른쪽에 위치한 경우
            // 툴팁을 왼쪽으로 전개
            $tooltip
                .removeClass("middle")
                .addClass("left")
                .css("max-width", wrapperLeft + "px");
        }
    }

    // 툴팁 활성화
    function activateTooltip() {
        adjustTooltipOffset(this); // 좌표 조정

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
