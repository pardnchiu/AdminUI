<!DOCTYPE html>
<html lang="zh-Hans-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>入口頁</title>
    <!--  -->
    <?php include "head/scripts.php" ?>
</head>

<body id="body">
    <?php if (isset($is_auth) && $is_auth): ?>
        <!--  -->
        <section>
            <!--  -->
            <?php include "components/leftTab.php"; ?>
            <!--  -->
            <section class="system-block-body-right">
                <!--  -->
                <?php include "components/rightNav.php"; ?>
                <!--  -->
                <header>
                    <strong>入口頁</strong>
                    <section></section>
                </header>
                <!--  -->
                <p class="hint">還沒想好放什麼合適</p>
            </section>
        </section>
    <?php else: ?>
        <section class="login">
            <!--  -->
            <?php include "components/login.php"; ?>
        </section>
    <?php endif; ?>
    <script>
        document.addEventListener("DOMContentLoaded", _ => {
            page = new QUI({
                id: "body",
                data: {
                    title: "PARDN.IO 後台管理",
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