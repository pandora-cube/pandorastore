<div style="font-family: 'Noto Sans Korean', 'Malgun Gothic', Dotum, Helvetica, Arial, sans-serif;">
<div style="width: 578px; margin: 0 auto; padding: 10px; border: 1px solid #aaa; border-bottom: none;">
    <p style="margin: 1em 0; font-weight: bold; font-size: 1.3em; text-align: center;">판도라스토어에 오신 것을 환영합니다.</p>
    <p style="margin: .7em 0;"><?=$this->getAttribute("nickname")?> 님, 안녕하세요.</p>
    <p style="margin: 0;">이 메일은 회원 가입을 마무리하기 위한 계정 인증 메일입니다.</p>
    <p style="margin: 0;">계정 인증을 완료하려면 다음의 <u>확인 방법 중 하나</u>를 선택하십시오.</p>
    <p style="margin: .7em 0 0 0; font-weight: bold;">* 아래의 버튼을 클릭하여 주십시오.</p>
    <p style="margin: 0 0 .7em 0;">(계정 인증을 다시 요청한 경우 이 버튼이 유효하지 않을 수 있습니다.)</p>
    <div style="margin: 10px; text-align: center;">
        <a href="<?=$this->getAttribute("auth_href")?>" style="display: inline-block; padding: 7px 10px; font-weight: bold; text-decoration: none; color: white; background-color: #8badc9;">계정 인증</a>
    </div>
    <p style="margin: .7em 0; font-weight: bold;">* 인증코드 입력 페이지가 열려 있는 경우 아래의 인증코드를 기입하십시오.</p>
    <div style="margin: 10px; padding: 7px 10px; background-color: #aaa; color: white;">
        <?=$this->getAttribute("auth_code")?>
    </div>
    <p style="margin: 0;">이용해 주셔서 감사합니다.</p>
    <p style="margin: 0;">서성범 올림.</p>
</div>
<div style="width: 580px; margin: 0 auto; padding: 15px 10px; text-align: center; color: #aaa; background-color: #333;">
    <img src="http://p-store.kr/images/logo_dark.png" alt="판도라스토어 로고" style="width: 200px;" />
    <p style="margin: 0;">Copyright ⓒ2017 teamVENT. All rights reserved.</p>
</div>
</div>