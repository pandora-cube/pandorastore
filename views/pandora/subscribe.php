<!doctype html>
<html xml:lang="ko" lang="ko">
<head>
	<?=$this->loadLayout("head")?>
    	<link rel="stylesheet" href="/stylesheets/accounts.css" />
</head>

<body>
    <header>
        <?=$this->loadLayout("header")?>
    </header>
	
    <div id="contents">
		  <form class="Subscribe-form" action="수신서버" method="post"> 
			  <h2>프로젝트 구독 페이지</h2> 
			
			  <div> 
				  <label for="subscribe_github">GitHub 구독 신청</label>
				  <input id="subscribe_github" name="github_account" placeholder="Email or Username" type="text"> 
				
				  <label for="subscribe_trello">Trello 구독 신청</label>
				  <input id="subscribe_trello" name="trello_account" placeholder="Email or Username" type="text"> 
				
				  <input type="submit" value="제출 하기"> 
			  </div> 
			
		  </form>
    </div>
    
    <footer>
        <?=$this->loadLayout("footer")?>
    </footer>

    <script src="/libraries/jquery.js"></script>
    <script src="/modules/stickymenu/stickymenu.js"></script>
    <script src="/scripts/header.js"></script>
</body>
</html>
