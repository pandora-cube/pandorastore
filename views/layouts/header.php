<!-- 스킵 네비게이션 -->
<a id="skip-nav" href="#contents">메뉴 건너뛰기</a>
<!-- 헤더 -->
<div class="headerArea">
    <!-- 모바일용 메뉴 열기 버튼 -->
    <a class="open-menu" href="#whole-menu" title="메뉴" role="button"></a>
    <!-- 모바일용 검색폼 열기 버튼 -->
    <button class="open-search" title="검색"></button>
    <!-- 로고 -->
    <h1>
        <a href="/">판도라스토어</a>
    </h1>
    <!-- 검색 -->
    <form class="search" action="/" method="get">
        <input name="search" type="text" placeholder="검색어를 입력해 주세요." />
        <input type="submit" value="검색" />
    </form>
</div>
<!-- 메뉴 -->
<div id="whole-menu" class="menuArea">
    <div class="background"></div>
    <ul class="menu">
        <li>
            <div class="title-wrapper" tabindex="0">
                <span class="title">판도라</span>
            </div>
            <ul class="inner-menu">
                <li><a href="http://p-cube.kr" target="_blank">판도라큐브 카페</a></li>
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
    <div id="topOrbit" class="orbitArea"></div>
<?php endif; ?>
