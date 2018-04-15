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
            <input id="Title" name="Title" type="text" placeholder="콘텐츠의 제목" required />

            <label for="Creator">제작자</label>
            <label for="Creator" class="description">제작자가 모두 판도라스토어에 가입되어 있어야 합니다.</label>
            <input id="Creator" name="Creator" type="text" placeholder="팀명(팀원) 혹은 제작자명" required />

            <label for="Genre">장르</label>
            <input id="Genre" name="Genre" type="text" placeholder="콘텐츠의 장르" required />

            <label for="Platform">환경</label>
            <input id="Platform" name="Platform" type="text" placeholder="콘텐츠를 이용 가능한 플랫폼" required />

            <label for="Description">소개</label>
            <textarea id="Description" name="Description" placeholder="콘텐츠 열람 시 노출될 소개문" required></textarea>

            <div class="files-header">
                <label>파일</label>
                <button class="add-file">
                    <i class="material-icons">&#xE145;</i>
                    <span>추가</span>
                </button>
            </div>
            <ul class="files">
                <template>
                    <input class="platform-input" name="platform" type="text" placeholder="환경" />

                    <div class="url">
                        <input class="url-input" name="url" type="text" placeholder="URL 입력" />
                        <button class="url-apply">
                            <div>확인</div>
                        </button>
                    </div>

                    <span class="or">혹은</span>

                    <input name="MAX_FILE_SIZE" type="hidden" value="536870912" /> <!-- 최대용량 512MB -->
                    <input class="select-file-input" name="file" type="file" />
                    <button class="select-file-button">
                        <i class="material-icons">&#xE2C6;</i>
                        <span>파일 선택</span>
                    </button> 

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
