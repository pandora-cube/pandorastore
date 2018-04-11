<link rel="stylesheet" href="/libraries/modules/stickymenu/stickymenu.css" />
<link rel="stylesheet" href="/libraries/modules/bxSlider/jquery.bxslider.min.css" />
<script src="/libraries/modules/stickymenu/stickymenu.js"></script>
<script src="/libraries/modules/bxSlider/jquery.bxslider.min.js"></script>
<script src="/layouts/header/script.js"></script>

<!-- 스킵 네비게이션 -->
<a id="skip-nav" href="#contents">메뉴 건너뛰기</a>
<!-- 헤더 -->
<div class="headerArea">
    <!-- 모바일용 메뉴 열기 버튼 -->
    <a class="open-menu" href="#whole-menu" title="메뉴" role="button"></a>
    <!-- 모바일용 검색폼 열기 버튼 -->
    <button class="open-search" title="검색"></button>
    <!-- 로고 -->
    <h1><a href="/"><?=$this->getAttribute("LogoText")?></a></h1>
    <!-- 검색 -->
    <form class="search" action="/" method="get">
        <input name="search" type="text" placeholder="검색어를 입력해 주세요." />
        <input type="submit" class="show-for-desktop" value="&#xE8B6;" />
        <input type="submit" class="show-for-mobile" value="검색" />
    </form>

    <div class="user-menu">
        <?php if ($this->isEnabledArea("signin")): ?>
            <!-- 로그인 버튼 -->
            <a class="signin" href="/accounts/signin">로그인</a>
            <a class="signup" href="/accounts/signup">회원가입</a>
        <?php endif; ?>
        <?php if ($this->isEnabledArea("user-button")): ?>
            <div class="user-menu-item">
                <!-- 메시지 버튼 -->
                <button class="message-button">
                    <i class="material-icons closed">&#xE7F5;</i>
                    <i class="material-icons opened">&#xE7F5;</i>
                </button>
                <!-- 메시지 오버레이 -->
                <div class="message-overlay overlay">
                    <div class="arrow">
                        <div class="line"></div>
                        <div class="background"></div>
                    </div>
                    <ul class="container">
                    </ul>
                </div>
            </div>

            <div class="user-menu-item">
                <!-- 계정 버튼 -->
                <button class="accounts-menu-button">
                    <i class="material-icons closed">&#xE813;</i>
                    <i class="material-icons opened">&#xE815;</i>
                </button>
                <!-- 계정 메뉴 -->
                <div class="accounts-menu overlay">
                    <div class="arrow">
                        <div class="line"></div>
                        <div class="background"></div>
                    </div>
                    <ul class="container">
                        <li><a href="/accounts/signin_log">로그인 내역</a></li>
                        <li><a href="/accounts/signout">로그아웃</a></li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- 메뉴 -->
<div id="whole-menu" class="menuArea">
    <div class="background"></div>
    <ul class="menu">
        <li class="show-for-mobile">
            <?php if ($this->isEnabledArea("signin")): ?>
                <div class="title-wrapper">
                    <span class="title">계정</span>
                </div>
                <ul class="inner-menu">
                    <li><a href="/accounts/signin">로그인</a></li>
                    <li><a href="/accounts/signup">회원가입</a></li>
                </ul>
            <?php endif; ?>
            <?php if ($this->isEnabledArea("user-button")): ?>
                <div class="title-wrapper" tabindex="0">
                    <span class="title"><?=$this->getAttribute("Nickname")?> 님</span>
                </div>
                <ul class="inner-menu">
                    <li><a href="/accounts/signin_log">로그인 내역</a></li>
                    <li><a href="/accounts/signout">로그아웃</a></li>
                </ul>
            <?php endif; ?>
        </li>
        <li>
            <div class="title-wrapper" tabindex="0">
                <span class="title">판도라</span>
            </div>
            <ul class="inner-menu">
                <li><a href="http://p-cube.kr/welcome" target="_blank">판도라큐브 가입</a></li>
                <li><a href="http://cafe.naver.com/pcube" target="_blank">판도라큐브 카페</a></li>
                <li><a href="/pandora/calendar">판도라큐브 일정</a></li>
            </ul>
        </li>
        <li>
            <div class="title-wrapper" tabindex="0">
                <span class="title">게임</span>
            </div>
            <ul class="inner-menu">
                <li><a href="/"><b>전체</b></a></li>
                <li><a href="/category/G1">타이쿤</a></li>
                <li><a href="/category/G2">어드벤처</a></li>
                <li><a href="/category/G4">전략</a></li>
                <li><a href="/category/G5">퍼즐</a></li>
                <li><a href="/category/G6">보드</a></li>
                <li><a href="/category/G7">액션</a></li>
                <li><a href="/category/G8">캐주얼</a></li>
                <li><a href="/category/G9">아케이드</a></li>
                <li><a href="/category/G10">시뮬레이션</a></li>
            </ul>
        </li>
        <li>
            <div class="title-wrapper">
                <a class="title" href="/category/G3">소프트웨어</a>
            </div>
        </li>
    </ul>
</div>
<!-- 이미지 슬라이드 -->
<?php if ($this->isEnabledArea("topOrbit")): ?>
    <div class="slideArea">
        <div class="slideWrapper"></div>
    </div>
<?php endif; ?>