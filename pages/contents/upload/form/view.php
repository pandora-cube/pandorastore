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
        <form id="upload-form" action="/contents/upload/request" method="post" enctype="multipart/form-data">
            <h2>콘텐츠 등록</h2>

            <!-- 제목 -->
            <label for="Title">제목</label>
            <input id="Title" name="Title" type="text" placeholder="콘텐츠의 제목" required />

            <!-- 제작자 -->
            <label for="Creator">제작자</label>
            <label for="Creator" class="description">제작자가 모두 판도라스토어에 가입되어 있어야 합니다.</label>
            <label for="Creator" class="description">모든 제작자는 콘텐츠에 대해 관리 권한을 가집니다.</label>
            <input id="Creator" name="Creator" type="text" placeholder="팀명(팀원) 혹은 제작자명" required />

            <!-- 장르 -->
            <label for="Genre">장르</label>
            <input id="Genre" name="Genre" type="text" placeholder="콘텐츠의 장르" required />

            <!-- 환경 -->
            <label for="Platform">환경</label>
            <input id="Platform" name="Platform" type="text" placeholder="콘텐츠를 이용 가능한 플랫폼" required />

            <!-- 소개 -->
            <label for="Description">소개</label>
            <textarea id="Description" name="Description" placeholder="콘텐츠 열람 시 노출될 소개문" required></textarea>

            <!-- 파일 -->
            <input name="MAX_FILE_SIZE" type="hidden" value="<?=$this->getAttribute("MAX_FILE_SIZE")?>" /> <!-- 최대 용량 (Byte) -->
            <div class="files-header">
                <label>파일</label>
                <button class="add-file">
                    <i class="material-icons">&#xE145;</i>
                    <span>추가</span>
                </button>
            </div>
            <ul class="files">
                <!-- 파일 항목 영역 템플릿 -->
                <template>
                    <!-- 파일 실행 환경 -->
                    <input class="platform-input" name="platform" type="text" placeholder="환경" required />

                    <!-- 파일 입력 영역 -->
                    <div class="file-input">
                        <!-- 파일 URL 입력 영역 -->
                        <div class="url">
                            <!-- 파일 URL -->
                            <input class="url-input" name="url" type="text" placeholder="URL 입력" />
                            <!-- 파일 URL 입력 확인 버튼 -->
                            <button class="url-apply">
                                <div>확인</div>
                            </button>
                        </div>

                        <span class="or">혹은</span>

                        <!-- 파일 선택 input -->
                        <input class="select-file" name="file" type="file" />
                        <!-- 파일 선택 버튼 -->
                        <button class="select-file-button">
                            <i class="material-icons">&#xE2C6;</i>
                            <span>파일 선택</span>
                        </button>
                    </div>

                    <!-- 파일 이름 출력 영역 -->
                    <div class="file-name"></div>

                    <!-- 파일 항목 삭제 버튼 -->
                    <div class="delete-wrapper">
                        <button class="delete">
                            <span class="blind">삭제</span>
                            <i class="material-icons">&#xE15B;</i>
                        </button>
                    </div>
                </template>
            </ul>

            <!-- 제출 버튼 -->
            <input class="button_style_1" type="submit" value="제출" />
        </form>
    </div>

    <footer>
        <?=$this->loadLayout("footer")?>
    </footer>
</body>
</html>
