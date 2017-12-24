<!doctype html>
<html xml:lang="ko" lang="ko">
<head>
    <?=$this->loadLayout("head")?>
    <link rel="stylesheet" href="/stylesheets/pandora/calendar.css" />
</head>

<body>
    <header>
        <?=$this->loadLayout("header")?>
    </header>

    <div id="contents">
        <iframe class="calendar" src="https://calendar.google.com/calendar/embed?showTitle=0&amp;showCalendars=0&amp;showPrint=0&amp;height=600&amp;wkst=1&amp;bgcolor=%23F1F1F1&amp;src=pcube.team%40gmail.com&amp;color=%236B3304&amp;ctz=Asia%2FSeoul" frameborder="0" scrolling="no">
            <p>iframe을 지원하지 않는 브라우저입니다.</p>
        </iframe>
    </div>

    <footer>
        <?=$this->loadLayout("footer")?>
    </footer>

    <script src="/libraries/jquery.js"></script>
    <script src="/modules/stickymenu/stickymenu.js"></script>
    <script src="/scripts/header.js"></script>
</body>
</html>
