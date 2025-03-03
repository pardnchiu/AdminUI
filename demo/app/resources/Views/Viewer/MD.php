<!DOCTYPE html>
<html lang="zh-Hans-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Markdown 文檔：<?php echo $path; ?></title>
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
            <!--  -->
            <section class="system-page-text">
                <section>
                    <header>
                        <span>目前位置：<?php echo $filepath; ?></span>
                        <section>
                        </section>
                    </header>
                    <!--  -->
                    <section>
                        <section id="md-viewer"></section>
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

                        const elm_viewer = new MDViewer({
                            id: "md-viewer",
                            style: {
                                fill: 0
                            },
                            sync: {
                                delay: 10
                            }
                        });

                        elm_viewer.init(text);
                    }
                }
            });
        });
    </script>
</body>

</html>