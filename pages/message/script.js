function loadMessageView(senderNumber) {
    var $destNickname = $("#dest-nickname");
    var $view = $("#message-view");
    var nickname;

    // 초기화
    $destNickname.empty();
    $view.empty().append(
        $("<div>")
            .addClass("loading")
            .text("대화 내용을 불러오는 중입니다."));

    $.get("/message/load", {
        SenderNumber: senderNumber,
        UpdateToRead: true,
    }).done(function onSuccess(json) {
        var data = JSON.parse(json);
        var i;

        if (data.length === 0) {
            $view.empty().append(
                $("<div>")
                    .addClass("none")
                    .text("대화 내용이 없습니다."));
            return;
        }

        // 닉네임 전처리
        nickname = data[0].SenderNickname;
        if (nickname === null) {
            nickname = "미상";
        }

        $destNickname.text(nickname);
        $view.empty();

        for (i = 0; i < data.length; i++) {
            // 메시지 추가
            $view.append(
                $("<div>")
                    .append(
                        $("<div>")
                            .addClass("result")
                            .text(data[i].Result))
                    .append(
                        $("<div>")
                            .addClass("date")
                            .text(data[i].SendedTime)));
        }
    });
}

function loadMessageList() {
    var $list = $("#message-list");

    // 리스트 영역 초기화
    $list.empty().append(
        $("<div>")
            .addClass("none")
            .text("메시지가 없습니다."));

    $.get("/message/load", {
        Recents: true,
    }).done(function onSuccess(json) {
        var data = JSON.parse(json);
        var i;
        var nickname;
        var result;

        $list.empty();

        for (i = 0; i < data.length; i++) {
            // 닉네임 전처리
            nickname = data[i].SenderNickname;
            if (nickname === null) {
                nickname = "미상";
            }
            // 내용 전처리
            result = data[i].Result.split("\n")[0];

            // 메시지 추가
            $list.append(
                $("<a>")
                    .addClass("load-message-view")
                    .attr("href", "?to=" + data[i].SenderNumber)
                    .append(
                        $("<div>")
                            .addClass("nickname")
                            .text(nickname)
                            .append(
                                $("<span>")
                                    .addClass("badge")
                                    .text(data[i].Recents)))
                    .append(
                        $("<div>")
                            .addClass("date")
                            .text(data[i].SendedTime))
                    .append(
                        $("<div>")
                            .addClass("result")
                            .text(result)));
        }
    });
}

$(document).ready(function onDocumentReady() {
    loadMessageList();
});
