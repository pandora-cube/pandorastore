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

    <!-- 기타 텍스트박스 비활성용 스크립트-->
	<script language="javascript">
	 function active(){
	  document.form.textbox.disabled = false;

	  document.form.textbox.focus();
	 }
	 function disable(){
	  document.form.textbox.disabled = true;
	 }
	</script> 
	
    <div id="contents">
		<form class="deleteaccount-form" name="form" action="수신서버" method="post"> 
			<h2>판도라스토어 탈퇴 설문</h2> 
			
			<!-- 최대한 signup signin 페이지와 동일하게 만들어 봤습니다-->
			<label id="labelReason">탈퇴 사유</label>
			
			<input id="Reason_1" name="Reason" type="radio" required value="Reason1" onClick="javascript_:disable();"> 
			<label for="Reason_1">컨텐츠 부족</label> 
			
			<input id="Reason_2" name="Reason" type="radio" value="Reason2" onClick="javascript_:disable();"> 
			<label for="Reason_2">서비스 부족</label> 
			
			<input id="Reason_3" name="Reason" type="radio" value="Reason3" onClick="javascript_:disable();"> 
			<label for="Reason_3">시스템 장애</label> 
			
			<input id="Reason_4" name="Reason" type="radio" value="Reason4" onClick="javascript_:disable();"> 
			<label for="Reason_4">장기간 부재</label> 
			
			<input id="Reason_5" name="Reason" type="radio" value="Reason5" onClick="javascript_:active();"> 
			<label for="Reason_5">기타</label> 
			<textarea name="textbox" required disabled></textarea>
			
			
			<input type="submit" value="제출 하기"> 
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
