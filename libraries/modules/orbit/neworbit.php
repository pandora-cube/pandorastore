<!doctype html>
<html xml:lang="ko" lang="ko">

	<head>
		<?=$this->loadLayout("head")?>
    	<link rel="stylesheet" href="/stylesheets/accounts.css" />
	
		<!-- bxslider -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
		
		<script>
			// bxslider 호출 스크립트
			$(document).ready(function(){
				$('.slider').bxSlider({
					captions : true,
					slideWidth : $("#topOrbit").width()
				});
			});
		</script>
		
	</head>

	<body>	
		<header>
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
					<input name="search" type="text" placeholder="검색어를 입력해 주세요."> 
					<input type="submit" value="검색"> 
				</form> 
				
				<div class="accounts"> 
					<!-- 로그인 버튼 --> 
					<a class="signin" href="/accounts/signin">로그인</a> 
				</div>
			</div>
			
			<!-- 메뉴 -->
			<div id="whole-menu" class="menuArea"> 
				<div class="background"></div> <ul class="menu"> 
				
				<li> 
					<div class="title-wrapper" tabindex="0"> 
						<span class="title">판도라</span> 
					</div> 
					
				</li> 
				<li> 
					<div class="title-wrapper" tabindex="0"> 
						<span class="title">게임</span> 
					</div>
					
				</li> 
				<li> 
					<div class="title-wrapper"> 
						<a class="title" href="/category/G3">소프트웨어</a>
					</div> 
				</li> 
				</ul>
			</div>
			<!-- ------------------ 여기서 부터 슬라이드 위에는 개발용 헤더 무시해도 됨 ------------------ -->
				<div id="topOrbit" class="orbitArea">
					<ul class="orbit">
						<div class="slider">
							<!-- 슬라이드의 이미지는 가로0.4:세로1 비율로 잘라서 업로드 해야 함-->
							<!-- 슬라이드 1 -->
							<li>
								<img src="이미지 주소" title="Test Slide 1" alt="This is test slide image."/>
							</li>
							
							<!-- 슬라이드 2 -->
							<li>
								<img src="이미지 주소" title="Test Slide 2" alt="This is test slide image." />
							</li>
						</div>
					</ul>
				</div>
   		</header>
		
		<style>
			/* Slide CSS */
			
			ul.orbit li {
				height: 100%;
			}
			
			@media screen and (max-width: 50rem) { /* for Mobile */
				header .orbitArea {
					font-size: .8em;
					overflow: auto;
				}
				
				header ul.orbit {
					max-width: 100%;
				}
				
				.bx-wrapper .bx-caption span {
					width: 100%;
				}
				
				.bx-wrapper {
				margin-bottom: 38px;
				}
			}
			@media screen and (min-width: 50rem) { /* for Desktop */
				header .orbitArea {
					padding: 0 5rem;
					overflow: auto;
				}
				
				header ul.orbit {
					max-width: 1400px;
					margin: 0 auto;
				}
				
				.bx-wrapper .bx-caption span {
					padding: 0 2rem;
				}
				
				.bx-wrapper {
				margin-bottom: 40px;
				}
			}
			
			/* IMAGE CAPTIONS */
			
			.bx-wrapper .bx-caption {
				display: flex;
				flex-direction: column;
				width: 100%;
				height: inherit;
				align-items: center;
				position: absolute;
				bottom: 0;
				background: rgba(255, 255, 255, 0);
			}
			
			.bx-wrapper .bx-caption span {
				display: flex;
				flex-direction: column;
				height: 100%;
				align-items: center;
				justify-content: center;
				background-color: rgba(0, 0, 0, 0.5);
				color: #fff;
				font-size: 2em;
				padding: 0 2rem;
			}
			
			
			
			/* Slide Image */
			.bx-wrapper img{
				width: 100%;
				height: 100%;
			}
			
			</style>
		
		<div id="contents">
			<h1>
				Contents
			</h1>
		</div>

    <footer>
        <?=$this->loadLayout("footer")?>
    </footer>

    <script src="/libraries/jquery.js"></script>
    <script src="/modules/stickymenu/stickymenu.js"></script>
    <script src="/scripts/header.js"></script>
</body>
</html>

