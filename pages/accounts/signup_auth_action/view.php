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

    <div id="contents" class="wrapper">
        <form id="signup-complete" action="/accounts/signin" method="get">
            <h2>판도라스토어 회원 가입</h2>

            <?php if ($this->isEnabledArea("already-authenticated")): ?>
                <p><strong><?=$this->getAttribute("email")?></strong> 계정은 이미 가입되어 있습니다.</p>
            <?php endif; ?>

            <?php if ($this->isEnabledArea("auth-complete")): ?>
                <p><strong><?=$this->getAttribute("nickname")?></strong> 님, 회원 가입이 완료되었습니다.</p>
                <?php if ($this->isEnabledArea("pcube-member-inform")): ?>
                    <p>판도라큐브 회원 권한은 담당자가 확인 후 부여할 것입니다.</p>
                <?php endif; ?>
                <p>환영합니다!</p>
            <?php endif; ?>

            <input class="button_style_1" type="submit" value="로그인" />
        </form>
    </div>

    <footer>
        <?=$this->loadLayout("footer")?>
    </footer>
</body>
</html>
