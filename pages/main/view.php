<!doctype html>
<html xml:lang="ko" lang="ko">
<head>
    <?=$this->loadLayout("head")?>
    <link rel="stylesheet" href="/pages/main/stylesheet.css" />
    <link rel="stylesheet" href="/pages/contents/detail/stylesheet.css" />
    <link rel="stylesheet" href="/libraries/modules/modal/modal.css" />
    <link rel="stylesheet" href="/libraries/modules/tooltip/tooltip.css" />
    <script src="/libraries/modules/modal/modal.js"></script>
    <script src="/libraries/modules/tooltip/tooltip.js"></script>
    <script src="/libraries/scripts/toporbit.js"></script>
    <script src="/libraries/scripts/contentsdata.js"></script>
</head>

<body>
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "WebSite",
            "name": "판도라스토어",
            "url": "http://p-store.kr",
            "sameAs": [
                "http://cafe.naver.com/pcube",
                "https://play.google.com/store/apps/developer?id=%ED%8C%90%EB%8F%84%EB%9D%BC%ED%81%90%EB%B8%8C"
            ],
            "potentialAction": {
                "@type": "SearchAction",
                "target": "http://p-store.kr?search={search_term_string}",
                "query-input": "required name=search_term_string"
            }
        }
    </script>

    <header>
        <?=$this->loadLayout("header")?>
    </header>

    <div id="contents">
        <input id="filtered" type="hidden" value="<?=$this->getAttribute("filtered")?>" />
        <template name="contents-item">
            <div class="cover">
                <img />
            </div>
            <div class="summary">
                <p class="title"></p>
                <p class="creator"></p>
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
                <?=json_encode($this->getAttribute("category_description"))?>,
                <?=json_encode($this->getAttribute("tags"))?>);
            setSearchText(<?=json_encode($this->getAttribute("search"))?>);
        });
    </script>
</body>
</html>
