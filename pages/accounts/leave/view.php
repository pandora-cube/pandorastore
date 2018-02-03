<!doctype html>
<html xml:lang="ko" lang="ko">
<head>
	<?=$this->loadLayout("head")?>
	<link rel="stylesheet" href="/pages/accounts/stylesheet.css" />
    <script src="/pages/accounts/leave/script.js"></script>
</head>

<body>
    <header>
        <?=$this->loadLayout("header")?>
    </header>
	
    <div id="contents">
		<form id="leave-form" action="수신서버" method="post"> 
			<h2>판도라스토어 회원 탈퇴</h2> 
			
			<label id="labelReason">탈퇴 사유를 선택해 주십시오.</label>
			<div class="radio-wrapper">
				<input id="Reason_1" name="Reason" type="radio" value="콘텐츠 부족" required>
				<label for="Reason_1" class="leftradio">콘텐츠 부족</label>
				
				<input id="Reason_2" name="Reason" type="radio" value="서비스 부족" required>
				<label for="Reason_2">서비스 부족</label>
				
				<input id="Reason_3" name="Reason" type="radio" value="시스템 장애" required>
				<label for="Reason_3" class="rightradio">시스템 장애</label>
				
				<input id="Reason_4" name="Reason" type="radio" value="장기간 부재" required>
				<label for="Reason_4" class="leftradio">장기간 부재</label>
				
				<input id="Reason_5" name="Reason" type="radio" value="동아리 탈퇴" required>
				<label for="Reason_5">동아리 탈퇴</label>
				
				<input id="Reason_6" name="Reason" type="radio" value="기타" required> 
				<label for="Reason_6" class="rightradio">기타</label>
			</div>

			<textarea id="Detail" name="Detail" style="display: none;"></textarea>
			
			<input class="alert" type="submit" value="회원 탈퇴"> 
		</form>
    </div>

    <footer>
        <?=$this->loadLayout("footer")?>
    </footer>
</body>
</html>
