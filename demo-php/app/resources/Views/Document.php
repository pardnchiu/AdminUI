<!DOCTYPE html>
<html lang="zh-Hans-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文檔: <?php echo $path; ?></title>
    <!--  -->
    <?php include "head/scripts.php" ?>
</head>

<body id="body">
    <!--  -->
    <section>
        <!--  -->
        <?php include "components/leftTab.php"; ?>
        <!--  -->
        <section class="system-block-body-right">
            <!--  -->
            <?php include "components/rightNav.php"; ?>
            <!-- -->
            <header>
                <strong>文檔: <?php echo $path; ?></strong>
                <section></section>
            </header>
            <!--  -->
            <section class="system-page-text">
                <section>
                    <header>
                        <span>目前位置: <?php echo $path; ?></span>
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
                    title: "PARDN.IO 後台管理",
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