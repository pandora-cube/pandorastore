$(document).ready(function onDocumentReady() {
    $(".open-search").click(function openSearchForm() {
        $(".search").slideToggle();
    });

    // 사용자 메뉴 공통 콜백
    function openUserOverlay($overlay) {
        if ($overlay.css("display") !== "block") { // 오버레이가 닫혀 있는 경우
            $overlay.siblings("button.closed").hide();
            $overlay.siblings("button.opened").show();
            $overlay.addClass("opened").fadeIn();
        }
    }
    function closeUserOverlay($overlay) {
        $overlay.siblings("button.closed").show();
        $overlay.siblings("button.opened").hide();
        $overlay.removeClass("opened").fadeOut();
    }

    $(document).mouseup(function onMouseUp(e) {
        $(".user-menu .overlay.opened").each(function closeOverlay() {
            if ($(this).has(e.target).length === 0) { // 열려 있는 사용자 메뉴 바깥을 클릭한 경우
                closeUserOverlay($(this));
            }
        });
    });

    // 메시지 오버레이
    function loadUnreadMessages(open) {
        var $overlay = $(".user-menu .message-overlay");
        var $container = $overlay.find(".container");

        if ($overlay.css("display") === "block") { // 오버레이가 열려 있는 경우
            return;
        }

        $container.empty().append(
            $("<li>").append(
                $("<span>").text("메시지를 불러오는 중입니다.")));

        if (open) {
            openUserOverlay($overlay);
        }

        $.get("/message/load", {
            onlyUnread: true,
        }).done(function onSuccess(json) {
            var data = JSON.parse(json);
            var i;
            var nickname;
            var result;

            $container.empty();

            for (i = 0; i < data.length; i++) {
                // 닉네임 전처리
                nickname = data[i].SenderNickname;
                if (nickname === null) {
                    nickname = "미상";
                }
                // 내용 전처리
                result = data[i].Result.split("\n")[0];

                // 메시지 추가
                $container.append(
                    $("<li>").append(
                        $("<span>").html("<b>" + nickname + "</b>: " + result)));
            }

            // 새 메시지가 없는 경우
            if (data.length === 0) {
                $container.append(
                    $("<li>").append(
                        $("<span>").text("새 메시지가 없습니다.")));
            }
        }).fail(function onFail() {
            $container.empty().append(
                $("<li>").append(
                    $("<span>").text("메시지를 불러오지 못하였습니다.")));
        });
    }
    $(".user-menu .message-button").on("click", function onClick() { loadUnreadMessages(true); });
    loadUnreadMessages(false);

    // 계정 메뉴
    $(".user-menu .accounts-menu-button").on("click", function onClick() { openUserOverlay($(".user-menu .accounts-menu")); });
});

function setSearchText(text) {
    $("input[name=search]").val(text);

    if (text.length > 0) {
        $(".search").css("display", "block");
    }
}
