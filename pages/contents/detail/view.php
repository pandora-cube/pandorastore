<link rel="stylesheet" href="/libraries/modules/bxSlider/jquery.bxslider.min.css" />
<script src="/libraries/modules/bxSlider/jquery.bxslider.min.js"></script>
<script src="/pages/contents/detail/script.js"></script>

<input id="identifier" type="hidden" value="<?=$this->getAttribute("Identifier")?>" />
<input id="page-title" type="hidden" value="<?=$this->title?>" />

<?php if ($this->isEnabledArea("manage")): ?>
    <input id="enable-manage" type="hidden" />
<?php endif; ?>

<div class="top">
    <!-- 아이콘 -->
    <div class="cover">
        <img src="<?=$this->getAttribute("Thumbnail")?>" alt="<?=$this->getAttribute("ThumbnailAlt")?>" />
    </div>
    <!-- 콘텐츠 정보 -->
    <div class="summary">
        <p class="title"><?=$this->getAttribute("Title")?></p>
        <p>제작:
            <span class="creator"><?=$this->getAttribute("Creator")?></span>
            <?php if ($this->isEnabledArea("tooltip")): ?>
                <button class="tooltip-wrapper tooltip-icon">
                    <i class="material-icons">&#xE88E;</i>
                    <span class="tooltip"><?=$this->getAttribute("Creators")?></span>
                </button>
            <?php endif; ?>
        </p>
        <p>장르: <span class="genres"><?=$this->getAttribute("GenresList")?></span></p>
        <p>환경: <span class="platforms"><?=$this->getAttribute("PlatformsList")?></span></p>
    </div>
</div>

<!-- 다운로드 버튼 영역 -->
<div class="download">
    <?php foreach ($this->getAttribute("download-data") as $platform => $url): ?>
        <a href="<?=$url?>"><?=$platform?></a>
    <?php endforeach; ?>
</div>

<!-- 소개문 영역 -->
<div class="introductionArea">
    <div class="areaHeader">
        <span class="text">소개</span>
    </div>
    <?php if (strlen($this->getAttribute("Introduction")) > 0): ?>
        <p class="introduction"><?=$this->getAttribute("Introduction")?></p>
    <?php else: ?>
        <p class="introduction disabled">소개문이 등록되어 있지 않습니다.</p>
    <?php endif; ?>
</div>

<!-- 이미지 슬라이드 -->
<div class="slideArea">
    <div class="areaHeader">
        <span class="text">이미지</span>
    </div>
    <div class="slideWrapper">
        <?php for ($i = 0; $i < count($this->getAttribute("Images")); $i++): ?>
            <div class="image-wrapper">
                <img class="align-middle"
                    src="<?=$this->getAttribute("Images")[$i]?>"
                    title="<?=$this->getAttribute("ImagesTitle")[$i]?>"
                    alt="콘텐츠 이미지" />
            </div>
        <?php endfor; ?>
    </div>
</div>

<!-- 리뷰 -->
<div class="reviewArea">
    <div class="areaHeader">
        <span class="text">리뷰</span>
        <span class="num-reviews"></span>
        <div class="right">
            <button class="refresh">갱신</button>
        </div>
    </div>
    <!-- 리뷰 등록 -->
    <?php if ($this->isEnabledArea("review-write")): ?>
        <form class="write" action="/contents/reviews/write" method="post">
            <input name="content" type="hidden" value="<?=$this->getAttribute("Identifier")?>" />
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
                    <button class="edit-submit">수정</button>
                </div>
                <div class="wrapper delete-wrapper">
                    <button class="delete">삭제</button>
                    <button class="delete-cancel">취소</button>
                    <button class="delete-submit">삭제</button>
                </div>
            </div>
        </template>
    </div>
</div>
