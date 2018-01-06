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

            <label id="labelLastName" for="LastName">성명 <span class="alert"></span></label>
            <span class="multi">
                <input id="LastName" name="LastName" type="text" placeholder="성" required />
                <input name="FirstName" type="text" placeholder="이름" required />
            </span>
            <label id="labelUserID" for="UserID">이메일 <span class="alert"></span></label>
            <input id="UserID" name="UserID" type="email" required />
            <label id="labelPassword" for="Password">비밀번호 <span class="alert"></span></label>
            <input id="Password" name="Password" type="password" placeholder="비밀번호 생성" required />
            <input id="PasswordAgain" name="PasswordAgain" type="password" placeholder="비밀번호 확인" required />

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
    <script src="/scripts/signup.js"></script>
</body>
</html>
