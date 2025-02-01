<!DOCTYPE html>
<html lang="zh-Hans-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入頁</title>
    <!--  -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js" as="script" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
</head>

<body id="body">
    <script>
        const email = prompt("輸入管理者信箱\n\n範例請輸入 demo\n範例密碼為 0123456789\n\n未登入狀態唯一只能看見這一頁\n登入時效 1 小時");
        if (email) {
            let hash = CryptoJS.MD5(email).toString();

            location.href = "/?key=" + hash;
        } else {
            history.back();
        };
    </script>
</body>

</html>