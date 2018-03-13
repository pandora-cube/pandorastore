$(document).ready(function onDocumentReady() {
    function loadMessageList() {
        var $list = $("#message-list");

        // 리스트 영역 초기화
        $list.empty().append(
            $("<div>")
                .addClass("none")
                .text("메시지가 없습니다."));

        $.get("/message/load", {
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
                    $("<div>")
                        .append(
                            $("<div>")
                                .addClass("nickname")
                                .text(nickname))
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

    loadMessageList();
});
