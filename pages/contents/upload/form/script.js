$(document).ready(function onDocumentReady() {
    var fileNumber = 0;

    // 파일 URL 입력 영역 포커스 인 이벤트
    function onFileURLFocusedIn() {
        $(this).find(".url-apply").addClass("on");
    }

    // 파일 URL 입력 영역 포커스 아웃 이벤트
    function onFileURLFocusedOut(e) {
        var $button = $(this).find(".url-apply");

        // 새 포커스 타깃이 URL 입력 확인 버튼이 아닌 경우
        if (e.relatedTarget !== $button.get(0)) {
            $button.removeClass("on");
        }
    }

    // 파일 선택 버튼 클릭 이벤트
    function onSelectFileButtonClicked(event) {
        event.preventDefault();
        // for 데이터에 지정된 input[type=file] 클릭 트리거 실행
        $("#" + $(this).data("for")).click();
    }

    // 파일 이름 출력
    function showFileName($li, fileName) {
        /* eslint-disable indent */
        $li
            .find(".file-input") // 파일 입력 영역 비활성화
                .addClass("disabled")
                .end()
            .find(".file-name") // 파일 이름 출력 영역 활성화
                .addClass("enabled")
                .val(fileName)
                .end();
        /* eslint-enable */
    }

    // 파일 선택 완료 이벤트
    function onFileChanged() {
        var $li = $(this).parents("#upload-form .files li");
        var file = this.files[0]; // 선택된 파일 (클라이언트 로컬 파일)

        // 파일 선택이 정상적으로 완료된 경우 파일 이름 출력
        if (file !== undefined) {
            showFileName($li, file.name);
        }
    }

    // 파일 URL 입력 확인 이벤트
    function onFileURLEntered() {
        var $li = $(this).parents("#upload-form .files li");
        var fileName = $li.find(".url-input").val(); // 입력된 URL

        // 파일 URL 입력란이 비어있지 않은 경우 파일 이름 출력
        if (fileName.length > 0) {
            showFileName($li, fileName);
        } else {
            alert("파일 URL을 입력하십시오.");
        }

        event.preventDefault();
    }

    // 파일 입력 영역 제거
    function deleteFileRow(event) {
        $(this).parents("#upload-form .files li").remove();
        event.preventDefault();
    }

    // 파일 입력 영역 추가
    function addFileRow(event) {
        var $files = $("#upload-form .files");
        var template = $files.find("template").html();

        // 영역 내 input 엘리먼트들의 name 속성
        function getInputElementName() {
            // 본래의 name 속성 - 파일 번호
            return this.name + "-" + fileNumber;
        }

        /* eslint-disable indent */
        $files
            .append($("<li>") // 파일 입력 영역
                .html(template) // 템플릿 복사
                .find("input:not([name=MAX_FILE_SIZE])") // 영역 내의 input 엘리먼트들
                    .attr("name", getInputElementName)
                    .end()
                .find(".url") // 파일 URL 입력 영역
                    .on("focusin", onFileURLFocusedIn)
                    .on("focusout", onFileURLFocusedOut)
                    .find(".url-apply") // 파일 URL 입력 확인 버튼
                        .on("click", onFileURLEntered)
                        .end()
                    .end()
                .find(".select-file") // 파일 선택 input[type=file]
                    .attr("id", "file-" + fileNumber)
                    .on("change", onFileChanged)
                    .end()
                .find(".select-file-button") // 파일 선택 버튼
                    .data("for", "file-" + fileNumber)
                    .on("click", onSelectFileButtonClicked)
                    .end()
                .find(".delete") // 파일 입력 영역 제거 버튼
                    .on("click", deleteFileRow)
                    .end());
        /* eslint-enable */

        // 파일 번호 증가
        fileNumber += 1;

        if (event !== undefined) {
            event.preventDefault();
        }
    }

    $("#upload-form .add-file").on("click", addFileRow);

    addFileRow();
});
