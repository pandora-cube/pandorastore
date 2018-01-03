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
        <form class="signup-form" action="/accounts/createaccount" method="post">
            <h2>판도라스토어 회원 가입</h2>

            <label for="LastName">성명</label>
            <span class="multi">
                <input id="LastName" name="LastName" type="text" placeholder="성" required />
                <input name="FirstName" type="text" placeholder="이름" required />
            </span>
            <label for="UserID">이메일</label>
            <input id="UserID" name="UserID" type="email" required />
            <label for="Password">비밀번호</label>
            <input id="Password" name="Password" type="password" placeholder="비밀번호 생성" required />
            <input name="PasswordAgain" type="password" placeholder="비밀번호 확인" required />

            <label for="StudentID"><i>판도라큐브 회원인 경우 학번을 입력해 주십시오.</i></label>
            <input id="StudentID" name="StudentID" type="text" />

            <input type="submit" value="회원 가입" />
        </form>
    </div>

    <footer>
        <?=$this->loadLayout("footer")?>
    </footer>

    <script src="/libraries/jquery.js"></script>
    <script src="/modules/stickymenu/stickymenu.js"></script>
    <script src="/scripts/header.js"></script>
</body>
</html>
