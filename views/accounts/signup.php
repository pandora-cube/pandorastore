<!doctype html>
<html xml:lang="ko" lang="ko">
<head>
    <?=$this->loadLayout("head")?>
    <link rel="stylesheet" href="/stylesheets/accounts.css" />
</head>

<body>
    <header>
        <?=$this->loadLayout("header")?>
    </header>

    <div id="contents">
        <form id="signup-form" action="/accounts/signup_request" method="post">
            <h2>판도라스토어 회원 가입</h2>

            <label id="labelNickname" for="Nickname">닉네임 <span class="alert"></span></label>
            <input id="Nickname" name="Nickname" type="text" required />

            <label id="labelUserID" for="UserID">이메일 <span class="alert"></span></label>
            <input id="UserID" name="UserID" type="email" required />

            <label id="labelPassword" for="Password">비밀번호 <span class="alert"></span></label>
            <input id="Password" name="Password" type="password" placeholder="비밀번호 생성" required />
            <input id="PasswordCheck" name="PasswordCheck" type="password" placeholder="비밀번호 확인" required />

            <div>
                <input id="PCubeMember" name="PCubeMember" type="checkbox" />
                <label for="PCubeMember">판도라큐브 회원입니다.</label>
            </div>

            <div class="inner-form">
                <label id="labelLastName" for="LastName">성명 <span class="alert"></span></label>
                <span class="multi">
                    <input id="LastName" name="LastName" type="text" placeholder="성" />
                    <input id="FirstName" name="FirstName" type="text" placeholder="이름" />
                </span>

                <label id="labelUniv" for="Univ">소속 대학 및 학번<span class="alert"></span></label>
                <span class="multi">
                    <input id="Univ" name="Univ" type="text" placeholder="대학명 (ex. 판도라대학교)" />
                    <input id="StudentID" name="StudentID" type="number" placeholder="학번 (ex. 180108)" />
                </span>
                
                <label id="labelPart">파트 <span class="alert"></span></label>
                <div class="parts">
                    <input id="ProgrammingPart" name="Part" type="radio" value="Programming" />
                    <label for="ProgrammingPart">프로그래밍</label>
                    <input id="DesignPart" name="Part" type="radio" value="Design" />
                    <label for="DesignPart">디자인</label>
                    <input id="ArtPart" name="Part" type="radio" value="Art" />
                    <label for="ArtPart">아트</label>
                </div>
            </div>

            <input type="submit" value="회원 가입" />
        </form>
    </div>

    <footer>
        <?=$this->loadLayout("footer")?>
    </footer>

    <script src="/libraries/jquery.js"></script>
    <script src="/modules/stickymenu/stickymenu.js"></script>
    <script src="/scripts/header.js"></script>
    <script src="/scripts/signup.js"></script>
</body>
</html>
