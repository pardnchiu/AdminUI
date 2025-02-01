<!DOCTYPE html>
<html lang="zh-Hans-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>入口頁</title>
    <!--  -->
    <?php include __DIR__ . "/head/scripts.php" ?>
</head>

<body id="body">
    <?php if (isset($is_auth) && $is_auth): ?>
        <!--  -->
        <section>
            <!--  -->
            <?php include __DIR__ . "/components/LeftTab.php"; ?>
            <!--  -->
            <section class="system-block-body-right">
                <!--  -->
                <?php include __DIR__ . "/components/RightNav.php"; ?>
                <!--  -->
                <header>
                    <strong>入口頁</strong>
                    <section></section>
                </header>
                <!--  -->
                <p class="hint">還沒想好放什麼合適<br>先看看其他頁吧</p>
            </section>
        </section>
    <?php else: ?>
        <section class="login">
            <!--  -->
            <?php include "components/Login.php"; ?>
        </section>
    <?php endif; ?>
    <script>
        document.addEventListener("DOMContentLoaded", _ => {
            page = new QUI({
                id: "body",
                data: {
                    title: "AdminUI 後台模板",
                    password: "",
                },
                event: {
                    ...system_events,
                    ...auth_events
                },
                when: {
                    rendered: () => {
                        loginCheck();
                    }
                }
            });
        });
    </script>
</body>

</html>