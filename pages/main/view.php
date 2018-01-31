<!doctype html>
<html xml:lang="ko" lang="ko">
<head>
    <?=$this->loadLayout("head")?>
    <link rel="stylesheet" href="/pages/main/stylesheet.css" />
    <link rel="stylesheet" href="/modules/modal/modal.css" />
    <script src="/modules/modal/modal.js"></script>
    <script src="/scripts/toporbit.js"></script>
    <script src="/scripts/contentsdata.js"></script>
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
            <section class="top">
                <div class="cover">
                    <img />
                </div>
                <div class="summary">
                    <p class="title"></p>
                    <p>제작: <span class="creator"></span></p>
                    <p>장르: <span class="genres"></span></p>
                    <p>환경: <span class="platforms"></span></p>
                    <div class="reason-set">
                        <button class="download">내려받기</button>
                    </div>
                </div>
            </section>
            <div class="orbitArea"></div>
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
