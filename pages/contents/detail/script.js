$(document).ready(function onDocumentReady() {
    var $modal = $("#contents-detail");

    function resetReviews() {
        $modal.find(".reviews div.review").remove();
    }

    function applyReviews(data) {
        var $reviews = $modal.find(".reviews");
        var $review;
        var i;
        var nickname;
        var splitedTime;
        var date;
        var year;
        var month;
        var day;

        for (i = 0; i < data.length; i++) {
            $review = $("<div>")
                .addClass("review")
                .html($reviews.find("template.review").html());

            nickname = data[i].UserNickname;
            if (nickname === null) {
                nickname = "미상";
                $review.find(".writer").addClass("unknown");
            }

            splitedTime = data[i].WritedTime.split(/[- :]/);
            date = new Date(Date.UTC(splitedTime[0], splitedTime[1] - 1, splitedTime[2]));
            year = ("0000" + date.getFullYear()).slice(-4);
            month = ("00" + (date.getMonth() + 1)).slice(-2);
            day = ("00" + date.getDate()).slice(-2);

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
        }).done(loadReviews);
    }

    loadReviews();
    $modal.find(".write").on("submit", writeReview);
});
