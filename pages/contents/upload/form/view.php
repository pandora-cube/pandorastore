<!doctype html>
<html xml:lang="ko" lang="ko">
<head>
    <?=$this->loadLayout("head")?>
    <link rel="stylesheet" href="/pages/contents/upload/form/stylesheet.css" />
</head>

<body>
    <header>
        <?=$this->loadLayout("header")?>
    </header>

    <div id="contents">
        <form id="upload-form" action="/contents/upload/request" method="post">
            <h2>콘텐츠 등록</h2>

            <label for="Title">콘텐츠 제목</label>
            <input id="Title" name="Title" type="text" required />

            <label for="Creator">제작자</label>
            <input id="Creator" name="Creator" type="text" required />

            <label for="Genre">장르</label>
            <input id="Genre" name="Genre" type="text" required />

            <label for="Platform">환경</label>
            <input id="Platform" name="Platform" type="text" required />

            <label for="Description">콘텐츠 소개</label>
            <textarea id="Description" name="Description" required></textarea>

            <label>다운로드</label>
            <div class="downloads">
                <template>
                    <input type="text" placeholder="URL" />
                    <span>혹은</span>
                    <input name="MAX_FILE_SIZE" type="hidden" value="1073741824" /> <!-- 최대용량 1GB -->
                    <input type="file" />
                </template>
            </div>

            <input type="submit" value="제출" />
        </form>
    </div>

    <footer>
        <?=$this->loadLayout("footer")?>
    </footer>
</body>
</html>
