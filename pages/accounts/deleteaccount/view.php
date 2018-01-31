<!doctype html>
<html xml:lang="ko" lang="ko">
<head>
	<?=$this->loadLayout("head")?>
	<link rel="stylesheet" href="/pages/accounts/stylesheet.css" />
	
	<!-- inner style sheet-->
	<style>
		#contents form .deleteradio {
   			width: 100%;
    		line-height: calc(2rem - 2px);
    		margin-top: 1em;
 			text-align: center;
		}
		
		#contents form .deleteradio textarea {
  		  width: calc(100% - .5em - 2px);
 		  height: calc(3rem - 2px);
  		  margin: 1em 0;
  		  padding-left: .5em;
  		  border: 1px solid #AAA;
		}
		
		#contents form .deleteradio input[type=radio] {
			display: none;
		}
		
		#contents form .deleteradio input[type=radio] + label {
			display: inline-block;
			margin: 4px 0;
    			width: calc(100% / 3 - 1em);
   			height: calc(100% - 2px);
  			font-size: .9em;
  			text-align: center;
   			border: 1px solid #AAA;
   			cursor: pointer;
   			transition: background-color .5s, color .5s;
		}
		
		#contents form .deleteradio .leftradio {
			float: left;
		}
		
		#contents form .deleteradio .rightradio {
			float: right;
		}
		
		#contents form .deleteradio input[type=radio] + label:hover {
			background-color: #AAA;
		}

		#contents form .deleteradio input[type=radio]:checked + label {
			color: white;
			background-color: #AAA;
		}	
	</style>
</head>

<body>
    <header>
        <?=$this->loadLayout("header")?>
    </header>
	
    <!-- 기타 텍스트에리어 비활성용 스크립트-->
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
			<h3>탈퇴 사유</h3>
			
			<div class="deleteradio">
				<input id="Reason_1" name="Reason" type="radio" required value="Reason1" onClick="javascript_:disable();"> 
				<label for="Reason_1" class="leftradio">컨텐츠 부족</label> 
				
				
				<input id="Reason_2" name="Reason" type="radio" value="Reason2" onClick="javascript_:disable();"> 
				<label for="Reason_2">서비스 부족</label> 
				
				
				<input id="Reason_3" name="Reason" type="radio" value="Reason3" onClick="javascript_:disable();"> 
				<label for="Reason_3" class="rightradio">시스템 장애</label> 
				
				
				<input id="Reason_4" name="Reason" type="radio" value="Reason4" onClick="javascript_:disable();"> 
				<label for="Reason_4" class="leftradio">장기간 부재</label> 
				
				<input id="Reason_5" name="Reason" type="radio" value="Reason5" onClick="javascript_:disable();"> 
				<label for="Reason_5">동아리 탈퇴</label> 
				
				<input id="Reason_6" name="Reason" type="radio" value="Reason6" onClick="javascript_:active();"> 
				<label for="Reason_6" class="rightradio">기타</label> 
				<textarea name="textbox" required disabled></textarea>
			</div>
			
			<input type="submit" value="제출 하기"> 
		</form>
    </div>

    <footer>
        <?=$this->loadLayout("footer")?>
    </footer>
</body>
</html>
