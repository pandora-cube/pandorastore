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
        <form id="signup-auth-form" action="/accounts/signup_auth_action" method="get">
            <h2>판도라스토어 회원 가입</h2>

            <?php if ($this->isEnabledArea("auth-reinput")): ?>
                <p class="warning">입력하신 인증코드가 일치하지 않습니다. (<?=$this->getAttribute("count")?> / 3)</p>
            <?php endif; ?>

            <?php if ($this->isEnabledArea("auth-input")): ?>
                <p><strong><?=$this->getAttribute("email")?></strong>으로 인증코드를 발송하였습니다.</p>
                <p>인증 메일이 스팸 메일함에 있을 수 있습니다.</p>
                <p>인증코드를 입력하여 회원 가입을 완료해 주십시오.</p>
                <input name="email" type="hidden" value="<?=$this->getAttribute("email")?>" />
                <input id="AuthCode" name="authcode" type="text" placeholder="인증코드" />
                <input type="submit" value="인증" />
            <?php endif; ?>

            <?php if ($this->isEnabledArea("email-error")): ?>
                <p>오류가 발생하여 인증 과정에 차질이 생겼습니다.</p>
                <p>인증코드를 이메일로 받으신 경우 동봉된 링크를 통해 회원 가입을 완료해 주십시오.</p>
                <p>죄송합니다.&nbsp;&nbsp;:(</p>
            <?php endif; ?>

            <?php if ($this->isEnabledArea("auth-ban")): ?>
                <p>인증에 3회 이상 실패하여 더 이상 시도하실 수 없습니다.</p>
            <?php endif; ?>
        </form>
    </div>

    <footer>
        <?=$this->loadLayout("footer")?>
    </footer>
</body>
</html>
