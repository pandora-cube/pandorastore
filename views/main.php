<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1" />
	<link rel="stylesheet" href="stylesheets/common.css" />
	<link rel="stylesheet" href="stylesheets/main.css" />
	<link rel="stylesheet" href="modules/orbit/orbit.css" />
	<link rel="stylesheet" href="modules/stickymenu/stickymenu.css" />
	<link rel="stylesheet" href="modules/modal/modal.css" />
	<link rel="icon" href="favicon.ico" type="image/x-icon" />
	<title>Pandora Store</title>
</head>

<body>
	<header>
		<div class="headerArea">
			<!-- 로고 -->
			<h1>
				<a href="">판도라스토어</a>
			</h1>
			<!-- 링크 -->
			<ul class="links">
				<li><a href="http://sejong.ac.kr">세종대학교</a></li>
				<li><a href="http://p-cube.kr">판도라큐브</a></li>
				<li><a href="http://seongbum.com">서성범</a></li>
			</ul>
			<!-- 페이지 제목, 부제목 -->
			<div class="subject">
				<h2>세종관318</h2>
				<h3>판도라큐브 게임 스토어</h3>
			</div>
		</div>
		<!-- 여백 -->
		<div class="blankArea"></div>
		<!-- 메뉴 -->
		<div class="menuArea">
			<ul class="menu">
				<li>
					<div class="title"><a href="">홈</a></div>
				</li>
				<li>
					<div class="title"><a href="#">장르</a></div>
					<ul class="inner-menu">
						<li><a href="">타이쿤</a></li>
						<li><a href="">어드벤처</a></li>
						<li><a href="">소프트웨어</a></li>
					</ul>
				</li>
				<li>
					<div class="title"><a href="#">환경</a></div>
					<ul class="inner-menu">
						<li><a href="">Android</a></li>
						<li><a href="">iOS</a></li>
						<li><a href="">Windows</a></li>
						<li><a href="">Linux</a></li>
						<li><a href="">Mac OS</a></li>
						<li><a href="">웹</a></li>
					</ul>
				</li>
			</ul>
		</div>
		<!-- 이미지 슬라이드 -->
		<div class="orbitArea"></div>
	</header>

	<div id="contents">
		<h2>목록</h2>
		<div class="game-list">
			<cast>
				<div class="cover">
					<img />
				</div>
				<div class="summary">
					<p class="title"></p>
					<p class="creator"></p>
				</div>
			</cast>
		</div>
		<div name="game-detail" class="modal-origin">
			<section class="top">
				<div class="cover">
					<img />
				</div>
				<div class="summary">
					<p class="title"></p>
					<p>제작: <span class="creator"></span></p>
					<p>장르: <span class="genres"></span></p>
					<p>환경: <span class="platforms"></span></p>
				</div>
				<div class="reason-set">
					<button class="download">내려받기</button>
				</div>
			</section>
		</div>
	</div>

	<footer>
		<div class="footerArea">
			<div class="copyright">
				<img src="images/logo_dark.png" alt="판도라스토어 로고" />
				<div>Copyright ⓒ2017 teamVENT. All rights reserved.</div>
			</div>
		</div>
	</footer>

	<script src="libraries/jquery.js"></script>
	<script src="modules/orbit/orbit.js"></script>
	<script src="modules/stickymenu/stickymenu.js"></script>
	<script src="modules/modal/modal.js"></script>
	<script src="scripts/orbit.js"></script>
	<script src="scripts/gamelist.js"></script>
	<script src="scripts/clientinfo.js"></script>

	<script>
		$(document).ready(function() {
			loadOrbitData(<?=json_encode($orbit)?>);
			loadGameData(<?=json_encode($games)?>);
		});
	</script>
</body>
</html>
