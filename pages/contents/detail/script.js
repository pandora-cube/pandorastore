$(document).ready(function onDocumentReady() {
    var $modal = $("#contents-detail");

    function resetReviews() {
        $modal.find(".reviewArea .reviews div.review").remove();
    }

    function applyReviews(data) {
        var $reviews = $modal.find(".reviewArea .reviews");
        var $review;
        var i;
        var nickname;
        var splitedTime;
        var date;
        var year;
        var month;
        var day;

        for (i = 0; i < data.length; i++) {
            // 리뷰 영역 생성
            $review = $("<div>")
                .addClass("review")
                .html($reviews.find("template.review").html());

            // 작성자 정보가 옳바르지 않은 경우 '미상' 처리
            nickname = data[i].UserNickname;
            if (nickname === null) {
                nickname = "미상";
                $review.find(".writer").addClass("unknown");
            }

            // 작성일 형식 변환 (YYYY.MM.DD)
            splitedTime = data[i].WritedTime.split(/[- :]/);
            date = new Date(Date.UTC(splitedTime[0], splitedTime[1] - 1, splitedTime[2]));
            year = ("0000" + date.getFullYear()).slice(-4);
            month = ("00" + (date.getMonth() + 1)).slice(-2);
            day = ("00" + date.getDate()).slice(-2);

            // 삭제 권한이 있는 경우
            if (data[i].DeletePermission === true) {
                // 삭제 버튼 추가
                $("<button>")
                    .on("click", deleteReview)
                    .text("삭제")
                    .appendTo($review.find(".delete"));
            }

            // 데이터 적용 및 리뷰 영역 추가
            $review.data("review-id", data[i].ID);
            $review.find(".writer").text(nickname);
            $review.find(".date").text(year + "." + month + "." + day);
            $review.find(".result").text(data[i].Result);
            $review.appendTo($reviews);
        }
    }

    function loadReviews() {
        $.get("/contents/reviews/load", {
            content: $modal.data("identifier"),
        }).done(function onSuccess(json) {
            resetReviews();
            applyReviews(JSON.parse(json));
        });
    }

    function writeReview(event) {
        event.preventDefault();

        $.ajax(this.action, {
            method: this.method,
            data: $(this).serialize(),
        }).done(function onSuccess() {
            loadReviews();
            $modal.find(".reviewArea .write textarea").val("");
        });
    }

    function deleteReview() {
        $.post("/contents/reviews/delete", {
            review: $(this).parents(".review").data("review-id"),
        }).done(loadReviews);
    }

    loadReviews();
    $modal.find(".reviewArea .write").on("submit", writeReview);
});
