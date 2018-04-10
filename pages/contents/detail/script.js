$(document).ready(function onDocumentReady() {
    var $modal = $("#contents-detail");
    var identifier = $("#identifier").val();
    var pageTitle = $("#page-title").val();

    // Modal 닫힐 시
    $modal.on("close", function onModalClose() {
        window.location.hash = "#_";
    });

    // 문서의 타이틀 변경
    function applyDocumentTitle() {
        var originalTitle = $("title").text();
        $("title").text(pageTitle);

        $modal.on("close", function onModalClose() {
            $("title").text(originalTitle);
        });
    }

    // 이미지 슬라이드 불러오기
    function loadSlide() {
        var $slideWrapper = $modal.find(".slideArea .slideWrapper");
        var $images = $slideWrapper.find("img");

        if ($images.length === 1) {
            // 콘텐츠 이미지가 한 개일 시
            $slideWrapper.bxSlider({
                touchEnabled: false,
                pager: false,
                captions: true,
            });
        } else {
            // 콘텐츠 이미지가 여러 개일 시
            $slideWrapper.bxSlider({
                auto: true,
                autoControls: true,
                stopAutoOnClick: true,
                captions: true,
            });
        }
    }

    // 수정 활성화
    function activeEdit() {
        var $review = $(this).parents(".review");
        var $result = $review.find(".result");

        $review.find(".edit-input")
            .val($result.text())
            .height($result.height())
            .css("display", "block")
            .css("overflow", "auto")
            .focus();

        $review.find(".edit-wrapper .edit-cancel")
            .css("display", "block"); // 취소 버튼 활성화
        $review.find(".edit-wrapper .edit-submit")
            .css("display", "block"); // 확인 버튼 활성화
        $review.find(".edit-wrapper .edit")
            .css("display", "none"); // 수정 버튼 비활성화
        $result
            .css("display", "none");
    }

    // 수정 취소
    function cancelEdit() {
        var $review = $(this).parents(".review");

        $review.find(".result")
            .css("display", "block");
        $review.find(".edit-wrapper .edit")
            .css("display", "block");
        $review.find(".edit-wrapper .edit-cancel")
            .css("display", "none");
        $review.find(".edit-wrapper .edit-submit")
            .css("display", "none");
        $review.find(".edit-input")
            .css("display", "none");
    }

    // 삭제 활성화
    function activeDelete() {
        var $review = $(this).parents(".review");

        $review.find(".delete-wrapper .delete-cancel")
            .css("display", "block");
        $review.find(".delete-wrapper .delete-submit")
            .css("display", "block");
        $review.find(".delete-wrapper .delete")
            .css("display", "none");
    }

    // 삭제 취소
    function cancelDelete() {
        var $review = $(this).parents(".review");

        $review.find(".delete-wrapper .delete")
            .css("display", "block");
        $review.find(".delete-wrapper .delete-cancel")
            .css("display", "none");
        $review.find(".delete-wrapper .delete-submit")
            .css("display", "none");
    }

    // 리뷰 영역 초기화
    function resetReviews() {
        $modal.find(".reviewArea .reviews div.review").remove();
    }

    // 리뷰 데이터 불러오기
    function loadReviews() {
        $modal.find(".reviewArea .num-reviews")
            .text("불러오는 중");

        $.get("/contents/reviews/load", {
            content: identifier,
        }).done(function onSuccess(json) {
            resetReviews();
            applyReviews(JSON.parse(json));
        });
    }

    // 리뷰 작성
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

    // 리뷰 수정
    function editReview() {
        $.post("/contents/reviews/edit", {
            review: $(this).parents(".review").data("review-id"),
            result: $(this).parents(".review").find(".edit-input").val(),
        }).done(loadReviews);
    }

    // 리뷰 삭제
    function deleteReview() {
        $.post("/contents/reviews/delete", {
            review: $(this).parents(".review").data("review-id"),
        }).done(loadReviews);
    }

    // 리뷰 데이터 적용
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
        var result;

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

            // 수정 권한이 있는 경우
            if (data[i].EditPermission === true) {
                $review.find(".edit-wrapper .edit")
                    .on("click", activeEdit)
                    .css("display", "block");
                $review.find(".edit-wrapper .edit-cancel")
                    .on("click", cancelEdit);
                $review.find(".edit-wrapper .edit-submit")
                    .on("click", editReview);
            }

            // 삭제 권한이 있는 경우
            if (data[i].DeletePermission === true) {
                $review.find(".delete-wrapper .delete")
                    .on("click", activeDelete)
                    .css("display", "block");
                $review.find(".delete-wrapper .delete-cancel")
                    .on("click", cancelDelete);
                $review.find(".delete-wrapper .delete-submit")
                    .on("click", deleteReview);
            }

            // 개행문자를 줄바꿈으로 변환
            result = data[i].Result.replace(/\n/gi, "\n<br>");

            // 데이터 적용 및 리뷰 영역 추가
            $review.data("review-id", data[i].ID);
            $review.find(".writer").text(nickname);
            $review.find(".date").text(year + "." + month + "." + day);
            $review.find(".result").html(result);
            $review.appendTo($reviews);
        }

        // 리뷰 개수 출력
        $modal.find(".reviewArea .num-reviews")
            .text(data.length + "개");

        // 리뷰 갱신 버튼
        $modal.find(".reviewArea .refresh").on("click", loadReviews);
    }

    applyDocumentTitle();
    loadSlide();
    loadReviews();
    $modal.find(".reviewArea .write").on("submit", writeReview);
});
