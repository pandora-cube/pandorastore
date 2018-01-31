<!doctype html>
<html xml:lang="ko" lang="ko">
<head>
    <?=$this->loadLayout("head")?>
    <link rel="stylesheet" href="/pages/accounts/stylesheet.css" />
</head>

<body>
    <header>
        <?=$this->loadLayout("header")?>
    </header>

    <div id="contents">
        <form id="signin-form" action="/accounts/signin_auth" method="post">
            <h2>환영합니다.</h2>
            <input name="UserID" type="text" placeholder="이메일 혹은 닉네임" required />
            <input name="Password" type="password" placeholder="비밀번호" required />
            <input type="submit" value="로그인" />
        </form>
    </div>

    <footer>
        <?=$this->loadLayout("footer")?>
    </footer>
</body>
</html>
