<!doctype html>
<html xml:lang="ko" lang="ko">
<head>
	<?=$this->loadLayout("head")?>
	<link rel="stylesheet" href="/pages/accounts/stylesheet.css" />
	
	<!-- inner style sheet-->
	<style>
		#contents #gotohome{
			max-width: 500px;
			height: 300px;
			margin: 100px auto;
			text-align: center;
		}
		
		#contents #gotohome a {
			width: 100%;
			margin: 1em auto;
			padding: .5em 1em;
			font-size: 1em;
 			font-weight: bolder;
  			color: #8badc9;
  			background-color: #e7eef4;
  			border: 1px solid #8badc9;
  			border-radius: 1em;
 			cursor: pointer;
			transition: background-color .5s, color .5s;
		}
		
		#contents #gotohome a:hover {
			color: white;
			background-color: #8badc9;
		}
		
	</style>
</head>

<body>
	<header>
		<?=$this->loadLayout("header")?>
	</header>

	<div id="contents">
	    <div id="gotohome">
	      <h2>탈퇴되었습니다.</h2>
	      <a href="http://store.p-cube.kr/">홈으로 이동</a>
	    </div>
	</div>

    <footer>
        <?=$this->loadLayout("footer")?>
    </footer>
</body>
</html>
