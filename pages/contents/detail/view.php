<script src="/pages/contents/detail/script.js"></script>

<div class="top">
    <!-- 아이콘 -->
    <div class="cover">
        <img />
    </div>
    <!-- 콘텐츠 정보 -->
    <div class="summary">
        <p class="title"></p>
        <p>제작: <span class="creator"></span></p>
        <p>장르: <span class="genres"></span></p>
        <p>환경: <span class="platforms"></span></p>
    </div>
</div>

<!-- 다운로드 버튼 영역 -->
<div class="download"></div>

<!-- 이미지 슬라이드 -->
<div class="orbitArea"></div>

<!-- 리뷰 -->
<div class="reviewArea">
    <div class="header">
        <span class="text">리뷰</span>
        <span class="num-reviews"></span>
    </div>
    <!-- 리뷰 등록 -->
    <?php if ($this->isEnabledArea("review-write")): ?>
        <form class="write" action="/contents/reviews/write" method="post">
            <input name="content" type="hidden" />
            <textarea name="result"></textarea>
            <input type="submit" value="등록" />
        </form>
    <?php else: ?>
        <p class="write-disabled">판도라큐브 회원만 리뷰를 등록할 수 있습니다.</p>
    <?php endif; ?>
    <!-- 리뷰 목록 -->
    <div class="reviews">
        <template class="review">
            <div class="left">
                <p class="writer"></p>
                <p class="result"></p>
                <textarea class="edit-input"></textarea>
            </div>
            <div class="right">
                <p class="date"></p>
                <div class="wrapper edit-wrapper">
                    <button class="edit">수정</button>
                    <button class="edit-cancel">취소</button>
                    <button class="edit-submit">확인</button>
                </div>
                <div class="wrapper delete-wrapper">
                    <button class="delete">삭제</button>
                </div>
            </div>
        </template>
    </div>
</div>
