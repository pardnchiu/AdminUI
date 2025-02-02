<!DOCTYPE html>
<html lang="zh-Hans-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($is_media ? "影音" : "圖片") . "：" . $path; ?></title>
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
            <section class="system-page-media">
                <section>
                    <header>
                        <span>目前位置：<?php echo $filepath; ?></span>
                        <section>
                        </section>
                    </header>
                    <!--  -->
                    <section>
                        <?php
                        if ($is_media) {
                            echo <<<HTML
                            <section id="Fply" data-src="$filepath"></section>
                            HTML;
                        } else {
                            echo <<<HTML
                            <img src="$filepath">
                            HTML;
                        }
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

                        const elm = document.getElementById("Fply");

                        if (elm != null) {
                            const src = elm.dataset.src;
                            const dom = new FPlyr({
                                id: "Fply",
                                video: src,
                                option: {
                                    showThumb: true,
                                    panelType: "minimal",
                                    panel: [
                                        "play", "progress", "time", "timeMini",
                                        "volume", "volumeMini", "rate", "full"
                                    ],
                                    volume: 100,
                                    mute: false
                                },
                                when: {
                                    ready: function() {
                                        console.log("Player is ready");
                                    },
                                    playing: function() {
                                        console.log("Playing");
                                    },
                                    pause: function() {
                                        console.log("Paused");
                                    },
                                    end: function() {
                                        console.log("Playback ended");
                                    },
                                    destroyed: function() {
                                        console.log("Player removed");
                                    }
                                }
                            });
                        }

                        // if (type === "image") {
                        //     const img = document.createElement("img");
                        //     img.src = path;
                        //     img.alt = "Image";
                        //     document.getElementById("Fply").parentElement.appendChild(img);
                        // } else {
                        // }
                    }
                }
            });
        });
    </script>
</body>

</html>