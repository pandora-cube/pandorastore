<!doctype html>
<html>
<head>
	<?=$this->loadLayout("head")?>
	<link rel="stylesheet" href="/stylesheets/main.css" />
	<link rel="stylesheet" href="/modules/orbit/orbit.css" />
	<link rel="stylesheet" href="/modules/stickymenu/stickymenu.css" />
	<link rel="stylesheet" href="/modules/modal/modal.css" />
</head>

<body>
	<header>
		<?=$this->loadLayout("header")?>
	</header>

	<div id="contents">
		<h2>목록</h2>
		<div class="game-list">
			<template>
				<div class="cover">
					<img />
				</div>
				<div class="summary">
					<p class="title"></p>
					<p class="creator"></p>
				</div>
			</template>
		</div>
		<template name="game-detail" class="modal-origin">
			<section class="top">
				<div class="cover">
					<img />
				</div>
				<div class="summary">
					<p class="title"></p>
					<p>제작: <span class="creator"></span></p>
					<p>장르: <span class="genres"></span></p>
					<p>환경: <span class="platforms"></span></p>
					<div class="reason-set">
						<button class="download">내려받기</button>
					</div>
				</div>
			</section>
			<div class="orbitArea"></div>
		</template>
	</div>

	<footer>
		<?=$this->loadLayout("footer")?>
	</footer>

	<script src="/libraries/jquery.js"></script>
	<script src="/modules/orbit/orbit.js"></script>
	<script src="/modules/stickymenu/stickymenu.js"></script>
	<script src="/modules/modal/modal.js"></script>
	<script src="/scripts/toporbit.js"></script>
	<script src="/scripts/gamedata.js"></script>
	<script src="/scripts/clientinfo.js"></script>

	<script>
		$(document).ready(function() {
			loadTopOrbitData(<?=json_encode($this->getAttribute("orbit"))?>);
			loadGameData(<?=json_encode($this->getAttribute("games"))?>);
		});
	</script>
</body>
</html>
