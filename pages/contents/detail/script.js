$(document).ready(function onDocumentReady() {
    var $modal = $("#contents-detail");

    function resetReviews() {
        $modal.find(".reviews div.review").remove();
    }

    function applyReviews(data) {
        var $reviews = $modal.find(".reviews");
        var $review;
        var i;
        var date;
        var year;
        var month;
        var day;

        for (i = 0; i < data.length; i++) {
            date = new Date(data[i].WritedTime);
            year = ("0000" + date.getFullYear()).slice(-4);
            month = ("00" + date.getMonth()).slice(-2);
            day = ("00" + date.getDay()).slice(-2);

            $review = $("<div>")
                .addClass("review")
                .html($reviews.find("template.review").html());

            $review.find(".writer").text(data[i].UserNickname);
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

    loadReviews();
});
