<!DOCTYPE html>
<html lang="zh-Hans-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文檔編輯：<?php echo $path; ?></title>
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
                            <?php
                            if ($is_md) {
                                $href = "/viewer/md" . $filepath;
                                echo <<<HTML
                                <a href="$href">
                                    <i class="fa-brands fa-markdown"></i>
                                </a>
                                HTML;
                            }
                            ?>
                        </section>
                    </header>
                    <!--  -->
                    <section>
                        <textarea id="TextEditor" oninput="this.nextElementSibling.innerHTML = this.value.replace(/\n/g, '<br>')"></textarea>
                        <pre></pre>
                    </section>
                </section>
            </section>
        </section>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", async _ => {
            let text = <?php
                $text = htmlspecialchars($text ?? "", ENT_QUOTES | ENT_HTML5, 'UTF-8');
                echo json_encode($text, JSON_UNESCAPED_UNICODE);
            ?>;
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

                        let dom = document.getElementById("TextEditor")
                        dom.value = text;
                        dom.nextElementSibling.innerHTML = text.replace(/\n/g, '<br>')
                    }
                }
            });
        });
    </script>
</body>

</html>