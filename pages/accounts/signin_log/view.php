<!doctype html>
<html xml:lang="ko" lang="ko">
<head>
    <?=$this->loadLayout("head")?>
    <link rel="stylesheet" href="/pages/accounts/signin_log/stylesheet.css" />
</head>

<body>
    <header>
        <?=$this->loadLayout("header")?>
    </header>

    <div id="contents">
        <h2>로그인 내역</h2>

        <p class="notice">로그인 내역은 통신비밀보호법에 의거하여 <u>최대 90일</u>까지만 보관됩니다.</p>

        <table class="table_style_1">
            <caption class="blind">로그인 내역</caption>
            <colgroup>
            </colgroup>
            <thead>
                <tr>
                    <th scope="col">일시</th>
                    <th scope="col">IP</th>
                    <th scope="col">국가</th>
                    <th scope="col">플랫폼</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->getAttribute("log_data") as $log_datum): ?>
                    <tr>
                        <td><?=$log_datum["Date"]?></td>
                        <td><?=$log_datum["IP"]?></td>
                        <td><?=$log_datum["Country"]?></td>
                        <td><?=$log_datum["Platform"]?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <?=$this->loadLayout("footer")?>
    </footer>
</body>
</html>
