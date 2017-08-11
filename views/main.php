<!doctype html>
<html>
<head>
	<?=$this->loadLayout("head")?>
	<link rel="stylesheet" href="stylesheets/main.css" />
	<link rel="stylesheet" href="modules/orbit/orbit.css" />
	<link rel="stylesheet" href="modules/stickymenu/stickymenu.css" />
	<link rel="stylesheet" href="modules/modal/modal.css" />
</head>

<body>
	<header>
		<?=$this->loadLayout("header")?>
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
		<?=$this->loadLayout("footer")?>
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
			loadOrbitData(<?=json_encode($this->getVariable("orbit"))?>);
			loadGameData(<?=json_encode($this->getVariable("games"))?>);
		});
	</script>
</body>
</html>
