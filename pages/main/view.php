<!doctype html>
<html xml:lang="ko" lang="ko">
<head>
    <?=$this->loadLayout("head")?>
    <link rel="stylesheet" href="/pages/main/stylesheet.css" />
    <link rel="stylesheet" href="/pages/contents/detail/stylesheet.css" />
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
