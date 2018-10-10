$(document).ready(function onDocumentReady() {
    var fileNumber = 0;
    var creatorNumber = 0;
    var genreNumber = 0;
    var platformNumber = 0;

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
                .text(fileName)
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

    // 제작팀원 항목 제거
    function deleteCreator(event) {
        var $creators = $(this).parents("#upload-form .creators");

        $(this).parents("#upload-form .creators > .item").remove();

        if ($creators.find(".item").length === 0) {
            $creators.find(".no-item").removeClass("hidden");
        }

        event.preventDefault();
    }

    // 제작팀원 헝목 추가
    function onCreatorDataResponse(json) {
        var $creators = $("#upload-form .creators");
        var template = $("#gp-item-template").html();
        var data = JSON.parse(json);
        var creatorUserNumber = data.UserNumber;
        var creatorName = data.Name;

        // 판도라스토어 회원 데이터 존재 여부 검사
        if (data.length === 0 || creatorUserNumber == null || creatorName == null) {
            alert("판도라스토어에 가입된 회원이 아닙니다.");
            return;
        }

        // 이미 추가된 팀원인지 검사
        if ($("#upload-form .creators > .item input[value='" + creatorUserNumber + "']").length > 0) {
            alert("이미 추가된 팀원입니다.");
            return;
        }

        // 영역 내 input 엘리먼트의 name 속성
        function getInputElementName() {
            return "Creator-" + creatorNumber;
        }

        /* eslint-disable indent */
        $creators
            .append($(template)
                .addClass("item")
                .find("input")
                    .attr("name", getInputElementName)
                    .val(creatorUserNumber)
                    .end()
                .find(".name")
                    .text(creatorName)
                    .end()
                .find(".delete")
                    .on("click", deleteCreator)
                    .end())
            .find(".no-item")
                .addClass("hidden");
        /* eslint-enable */

        // 팀원 번호 증가
        creatorNumber++;
    }
    function addCreator(event) {
        var creatorName = $("#Creator").val();

        $.post("/contents/upload/get_creator", {
            name: creatorName,
        }).done(onCreatorDataResponse);

        if (event !== undefined) {
            event.preventDefault();
        }
    }

    // 장르 항목 제거
    function deleteGenre(event) {
        var $genres = $(this).parents("#upload-form .genres");

        $(this).parents("#upload-form .genres > .item").remove();

        if ($genres.find(".item").length === 0) {
            $genres.find(".no-item").removeClass("hidden");
        }

        event.preventDefault();
    }

    // 장르 항목 추가
    function addGenre(event) {
        var $genres = $("#upload-form .genres");
        var template = $("#gp-item-template").html();
        var selectedGenreID = $("#Genre").val();
        var selectedGenreName = $("#Genre option:selected").text();

        // 이미 추가된 항목인지 검사
        if ($("#upload-form .genres > .item input[value='" + selectedGenreID + "']").length > 0) {
            alert("이미 추가된 장르입니다.");
            return;
        }

        // 영역 내 input 엘리먼트의 name 속성
        function getInputElementName() {
            return "Genre-" + genreNumber;
        }

        /* eslint-disable indent */
        $genres
            .append($(template)
                .addClass("item")
                .find("input")
                    .attr("name", getInputElementName)
                    .val(selectedGenreID)
                    .end()
                .find(".name")
                    .text(selectedGenreName)
                    .end()
                .find(".delete")
                    .on("click", deleteGenre)
                    .end())
            .find(".no-item")
                .addClass("hidden");
        /* eslint-enable */

        // 장르 번호 증가
        genreNumber++;

        if (event !== undefined) {
            event.preventDefault();
        }
    }

    // 플랫폼 항목 제거
    function deletePlatform(event) {
        var $platforms = $(this).parents("#upload-form .platforms");

        $(this).parents("#upload-form .platforms > .item").remove();

        if ($platforms.find(".item").length === 0) {
            $platforms.find(".no-item").removeClass("hidden");
        }

        event.preventDefault();
    }

    // 플랫폼 항목 추가
    function addPlatform(event) {
        var $platforms = $("#upload-form .platforms");
        var template = $("#gp-item-template").html();
        var selectedPlatformID = $("#Platform").val();
        var selectedPlatformName = $("#Platform option:selected").text();

        // 이미 추가된 항목인지 검사
        if ($("#upload-form .platforms > .item input[value='" + selectedPlatformID + "']").length > 0) {
            alert("이미 추가된 플랫폼입니다.");
            return;
        }

        // 영역 내 input 엘리먼트의 name 속성
        function getInputElementName() {
            return "Platform-" + platformNumber;
        }

        /* eslint-disable indent */
        $platforms
            .append($(template)
                .addClass("item")
                .find("input")
                    .attr("name", getInputElementName)
                    .val(selectedPlatformID)
                    .end()
                .find(".name")
                    .text(selectedPlatformName)
                    .end()
                .find(".delete")
                    .on("click", deletePlatform)
                    .end())
            .find(".no-item")
                .addClass("hidden");
        /* eslint-enable */

        // 플랫폼 번호 증가
        platformNumber++;

        if (event !== undefined) {
            event.preventDefault();
        }
    }

    // 파일 항목 영역 제거
    function deleteFileRow(event) {
        $(this).parents("#upload-form .files li").remove();
        event.preventDefault();
    }

    // 파일 항목 영역 추가
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
            .append($("<li>") // 파일 항목 영역
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
                .find(".delete") // 파일 항목 영역 제거 버튼
                    .on("click", deleteFileRow)
                    .end());
        /* eslint-enable */

        // 파일 번호 증가
        fileNumber += 1;

        if (event !== undefined) {
            event.preventDefault();
        }
    }

    $("#upload-form .add-creator")
        .on("click", addCreator)
        .on("keydown", function onKeyDown(event) {
            if (event.keyCode === 13) {
                addCreator();
            }
        });
    $("#upload-form .add-genre").on("click", addGenre);
    $("#upload-form .add-platform").on("click", addPlatform);
    $("#upload-form .add-file").on("click", addFileRow);

    addFileRow();
});
