<!doctype html>
<html xml:lang="ko" lang="ko">
<head>
    <?=$this->loadLayout("head")?>
    <link rel="stylesheet" href="/pages/message/stylesheet.css" />
    <script src="/pages/message/script.js"></script>
</head>

<body>
    <header>
        <?=$this->loadLayout("header")?>
    </header>

    <div id="contents">
        <div id="message-list">
        </div>

        <div id="dest-nickname">
        </div>

        <div id="message-view">
        </div>
    </div>

    <footer>
        <?=$this->loadLayout("footer")?>
    </footer>

    <?php if ($this->isEnabledArea("load-message-view")): ?>
        <script>
            $(document).ready(function onDocumentReady() {
                loadMessageView(<?=$this->getAttribute("to")?>);
            });
        </script>
    <?php endif; ?>
</body>
</html>
