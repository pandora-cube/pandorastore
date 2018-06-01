<?php
require_once("models/user.php");

session_start();

loop:
if (isset($_SESSION["UserID"]) && isset($_SESSION["Password"])) { // 이미 로그인한 경우
    $user_model = new User($_SESSION["UserID"], $_SESSION["Password"], false);
    $user_data = $user_model->getData();

    if (is_null($user_data)) { // 로그인 정보가 유효하지 않은 경우
        session_destroy();
        goto loop;
    }

    $this->disableArea("signin");
    $this->setAttribute("Nickname", $user_data["Nickname"]);

    // 카테고리 정보 불러오기
    $categories_model = new Categories();
    $category_names = $categories_model->loadNames();
    $this->setAttribute("Category-Genres", $category_names["Genre"]);
    $this->setAttribute("Category-Platforms", $category_names["Platform"]);
} else {
    $this->disableArea("user-button");
}
if (explode(".", $_SERVER["HTTP_HOST"])[0] === "test") { // 테스트 사이트인 경우
    $this->setAttribute("LogoText", "PStore TW");
} else {
    $this->setAttribute("LogoText", "판도라스토어");
}
?>
