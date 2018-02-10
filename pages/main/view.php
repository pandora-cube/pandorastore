<!doctype html>
<html xml:lang="ko" lang="ko">
<head>
    <?=$this->loadLayout("head")?>
    <link rel="stylesheet" href="/pages/main/stylesheet.css" />
    <link rel="stylesheet" href="/libraries/modules/modal/modal.css" />
    <script src="/libraries/modules/modal/modal.js"></script>
    <script src="/libraries/scripts/toporbit.js"></script>
    <script src="/libraries/scripts/contentsdata.js"></script>
</head>

<body>
    <header>
        <?=$this->loadLayout("header")?>
    </header>

    <div id="contents">
        <template name="contents-item">
            <div class="cover">
                <img />
            </div>
            <div class="summary">
                <p class="title"></p>
                <p class="creator"></p>
            </div>
        </template>
        <template name="contents-detail" class="modal-origin">
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
                <!-- 리뷰 입력 -->
                <div class="input">
                    <textarea></textarea>
                    <button>입력</button>
                </div>
                <!-- 리뷰 목록 -->
                <div class="reviews">
                    <div class="review">
                        <p class="writer"></p>
                        <p class="result"></p>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <footer>
        <?=$this->loadLayout("footer")?>
    </footer>

    <script>
        $(document).ready(function() {
            loadTopOrbitData(<?=json_encode($this->getAttribute("orbit"))?>);
            loadContentsData(
                <?=json_encode($this->getAttribute("contents"))?>,
                <?=json_encode($this->getAttribute("category_name"))?>,
                <?=json_encode($this->getAttribute("tags"))?>);
            setSearchText(<?=json_encode($this->getAttribute("search"))?>);
        });
    </script>
</body>
</html>
