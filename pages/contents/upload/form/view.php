<!doctype html>
<html xml:lang="ko" lang="ko">
<head>
    <?=$this->loadLayout("head")?>
    <link rel="stylesheet" href="/pages/contents/upload/form/stylesheet.css" />
    <script src="/pages/contents/upload/form/script.js"></script>
</head>

<body>
    <header>
        <?=$this->loadLayout("header")?>
    </header>

    <div id="contents">
        <form id="upload-form" action="/contents/upload/request" method="post">
            <h2>콘텐츠 등록</h2>

            <label for="Title">제목</label>
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
            <button class="add-download">
                <i class="material-icons">&#xE145;</i>
                <span>추가</span>
            </button>
            <ul class="downloads">
                <template>
                    <input class="url" type="text" placeholder="URL 입력" />
                    <span class="or">혹은</span>
                    <label class="file-label">
                        <i class="material-icons">&#xE2C6;</i>
                        <span>파일 선택</span>
                    </label> 
                    <input name="MAX_FILE_SIZE" type="hidden" value="536870912" /> <!-- 최대용량 512MB -->
                    <input class="file-input" type="file" />
                    <div class="delete-wrapper">
                        <button class="delete">
                            <span class="blind">삭제</span>
                            <i class="material-icons">&#xE15B;</i>
                        </button>
                    </div>
                </template>

            </ul>

            <input class="button_style_1" type="submit" value="제출" />
        </form>
    </div>

    <footer>
        <?=$this->loadLayout("footer")?>
    </footer>
</body>
</html>
