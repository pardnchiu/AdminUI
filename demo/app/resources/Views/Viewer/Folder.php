<!DOCTYPE html>
<html lang="zh-Hans-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文檔：<?php echo $folder_path; ?></title>
    <!--  -->
    <?php include __DIR__ . "/../head/scripts.php" ?>
</head>

<body id="body">
    <!--  -->
    <section>
        <!--  -->
        <?php include __DIR__ . "/../components/LeftTab.php"; ?>
        <!--  -->
        <section class="system-block-body-right">
            <!--  -->
            <?php include __DIR__ . "/../components/RightNav.php"; ?>
            <!-- -->
            <header>
                <strong>檔案夾</strong>
                <section></section>
            </header>
            <!--  -->
            <section class="system-page-folder">
                <section>
                    <header>
                        <span>目前位置：<?php echo $folder_path; ?></span>
                        <section>
                        </section>
                    </header>
                    <!--  -->
                    <section>
                        <?php
                        foreach ($folders as $e) {
                            $href = $e["href"];
                            $folder_name = $e["folder_name"];
                            echo <<<HTML
                            <a href="$href" class="system-component-folder-row">
                                <div>
                                    <div></div>
                                </div>
                                <strong>$folder_name</strong>
                            </a>
                            HTML;
                        };
                        ?>
                        <?php
                        foreach ($files as $e) {
                            $href = $e["href"];
                            $src = $e["src"];
                            $filename = $e["filename"];
                            echo <<<HTML
                            <a href="$href" class="system-component-folder-row">
                                <img src="$src" alt="">
                                <strong>$filename</strong>
                            </a>
                            HTML;
                        };
                        ?>
                    </section>
                </section>
            </section>
        </section>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", async _ => {
            let text = <?php echo json_encode($text ?? "", JSON_UNESCAPED_UNICODE); ?>;
            page = new QUI({
                id: "body",
                data: {
                    title: "AdminUI 後台模板",
                },
                event: {
                    ...system_events,
                    ...auth_events
                },
                when: {
                    rendered: _ => {
                        loginCheck();
                    }
                }
            });
        });
    </script>
</body>

</html>