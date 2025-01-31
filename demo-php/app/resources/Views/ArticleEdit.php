<!DOCTYPE html>
<html lang="zh-Hans-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $article["title"] ?? "新增文章"; ?></title>
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
                <strong>
                    <?php
                    if (isset($article)) {
                        $title = $article["title"] ?? "";
                        echo <<<HTML
                        <a href="/articles">返回</a>
                        $title
                        HTML;
                    } else {
                        echo "新增文章";
                    };
                    ?>
                </strong>
                <section></section>
            </header>
            <!--  -->
            <section class="system-page-article" data-fill="0">
                <section>
                    <!-- 文章資訊 -->
                    <details>
                        <!--  -->
                        <summary>
                            <span>文章資訊 <i class="fa-solid fa-caret-right"></i></span>
                            <section>
                                <?php
                                if (isset($article)) {
                                    echo <<<HTML
                                    <button class="alert" @click="delete" data-uid="$uid">
                                        <i class="fa-solid fa-trash-can"></i>
                                        刪除
                                    </button>
                                    <button @click="update" data-uid="$uid">
                                        <i class="fa-solid fa-rotate"></i>
                                        更新
                                    </button>
                                    HTML;
                                } else {
                                    echo <<<HTML
                                    <button @click="create">
                                        <i class="fa-solid fa-calendar-plus"></i>
                                        發布
                                    </button>
                                    HTML;
                                };
                                ?>
                            </section>
                        </summary>
                        <!--  -->
                        <section>
                            <form id="input-form" class="system-component-form">
                                <span>基本設定</span>
                                <label class="_50" title="自訂 ID" data-hint="@username/[自訂 ID]">
                                    <section>
                                        <textarea name="slug" placeholder="自訂 ID" data-type="text" data-wrap="0" data-max="48" @input="textInput"><?php echo $article["slug"] ?? ""; ?></textarea>
                                        <pre><?php echo $article["slug"] ?? ""; ?></pre>
                                    </section>
                                </label>
                                <label class="_50" title="分類" data-hint="">
                                    <section>
                                        <select name="topic" id="">
                                            <option value="">選擇類別</option>
                                            <?php
                                            foreach ($topics as $e) {
                                                $selected = "";
                                                if ($e == $article["topic"]) {
                                                    $selected = "selected";
                                                };
                                                echo <<<HTML
                                                <option value="$e" $selected>$e</option>
                                                HTML;
                                            }
                                            ?>
                                        </select>
                                        or
                                        <input name="topic_new" type="text" placeholder="輸入類別">
                                    </section>
                                </label>
                                <label title="標題" data-hint="高度自增長輸入框 (不支持換行)">
                                    <section>
                                        <textarea name="title" placeholder="標題" data-required="1" data-type="text" data-max="48" data-wrap="0" @input="textInput"><?php echo $article["title"] ?? ""; ?></textarea>
                                        <pre><?php echo $article["title"] ?? ""; ?></pre>
                                    </section>
                                </label>
                                <label title="副標題" data-hint="高度自增長輸入框 (不支持換行)">
                                    <section>
                                        <textarea name="subtitle" placeholder="副標題" data-type="text" data-wrap="0" data-max="64" @input="textInput"><?php echo $article["subtitle"] ?? ""; ?></textarea>
                                        <pre><?php echo $article["subtitle"] ?? ""; ?></pre>
                                    </section>
                                </label>
                                <label title="標籤" data-hint="高度自增長輸入框 (標籤不支持換行, 點擊 Enter 自動轉換)">
                                    <section>
                                        <textarea name="hashtag" placeholder="標籤" data-type="text" @input="textInput" data-max="1024" @keyup="tagkeyup"><?php echo "#" . str_replace(",", " #", $article["hashtag"] ?? ""); ?></textarea>
                                        <pre><?php echo "#" . str_replace(",", " #", $article["hashtag"] ?? ""); ?></pre>
                                    </section>
                                </label>
                                <span>SEO 設定</span>
                                <label title="SEO 標題" data-hint="高度自增長輸入框 (不支持換行)">
                                    <section>
                                        <textarea name="seo_title" placeholder="SEO 標題" data-type="text" data-wrap="0" data-max="128" @input="textInput"><?php echo $article["seo_title"] ?? ""; ?></textarea>
                                        <pre><?php echo $article["seo_title"] ?? ""; ?></pre>
                                    </section>
                                </label>
                                <label title="SEO 描述" data-hint="高度自增長輸入框 (不支持換行)">
                                    <section>
                                        <textarea name="seo_description" placeholder="SEO 描述" data-type="text" data-max="256" data-wrap="0" @input="textInput"><?php echo $article["seo_description"] ?? ""; ?></textarea>
                                        <pre><?php echo $article["seo_description"] ?? ""; ?></pre>
                                    </section>
                                </label>
                            </form>
                        </section>
                    </details>
                    <!-- 文章本體 -->
                    <section>
                        <section class="system-page-article-editor">
                            <!-- 文章編輯 -->
                            <section id="article-editor"></section>
                        </section>
                        <section class="system-page-article-viewer">
                            <!-- 文章預覽 -->
                            <section id="article-viewer"></section>
                        </section>
                    </section>
                </section>
                <!--  -->
                <button @click="expand">
                    <i class="fa-solid fa-expand"></i>
                    <i class="fa-solid fa-compress"></i>
                </button>
            </section>
            <!--  -->
            <input id="image-uploader" type="file" accept="image/jpeg, image/png, image/gif, image/webp" :display="none">
        </section>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", _ => {
            let timer, elm_editor, elm_viewer;
            let content = <?php echo json_encode($article["content"] ?? "", JSON_UNESCAPED_UNICODE); ?>;

            page = new QUI({
                id: "body",
                data: {
                    title: "PARDN.IO 後台管理"
                },
                event: {
                    ...system_events,
                    ...auth_events,
                    textInput,
                    create: article_create,
                    update: article_update,
                    delete: article_delete
                },
                when: {
                    rendered: _ => {
                        elm_editor = new MDEditor({
                            id: "article-editor",
                            defaultContent: content,
                            showRow: 0,
                            hotKey: 1, // 啟用快捷鍵，預設為 1
                            // preventRefresh: 1,                   // 防止頁面重整，預設值：0
                            tabPin: 1, // 啟用 Tab 縮排，預設值：0 (關閉)
                            wrap: 1, // 啟用文字自動換行，預設值：1 (開啟)
                            autoSave: 1, // 自動儲存，預設值：1 (開啟)
                            event: {
                                save: result => { // 自定義儲存事件
                                    console.log(result); // 輸出當前 Markdown 內容
                                },
                                upload: article_upload
                            },
                            style: {
                                fill: 1, // 隨父元素大小調整，預設值：1
                                placeholder: {
                                    text: "Content", // 設定提示文字，預設：Type here ...
                                    color: "#0000ff80" // 提示文字顏色，預設：#0000ff1a
                                },
                            }
                        });

                        elm_viewer = new MDViewer({
                            id: "article-viewer",
                            style: {
                                fill: 1, // 隨父元素大小調整，預設值：1 | true
                            },
                            sync: {
                                editor: elm_editor, // 關聯的編輯器
                                delay: 50, // 更新延遲，單位ms，預設 300
                                scrollSync: 1, // 與編輯器同步滾動，預設值：0 | false
                            }
                        });

                        loginCheck();
                    },
                    beforeUpdate: _ => {
                        // * 停用畫面更新
                        return false;
                    }
                }
            });

            // * 上傳圖片
            async function article_upload() {
                const elm = document.getElementById("image-uploader");
                elm.click();

                let link;
                try {
                    const file = await new Promise((resolve, reject) => {
                        elm.addEventListener("change", () => {
                            if (elm.files.length > 0) {
                                resolve(elm.files[0]);
                            } else {
                                reject("沒有選擇檔案");
                            }
                        }, {
                            once: true
                        });
                    });

                    const allowedTypes = ["image/jpeg", "image/png", "image/gif", "image/webp"];
                    if (!allowedTypes.includes(file.type)) {
                        alert("只允許 JPG, PNG, GIF 或 WebP 格式的檔案！");
                        return null;
                    }

                    const formData = new FormData();
                    formData.append("image", file);

                    console.log("0")
                    // 直接等待 fetch 的結果
                    const response = await fetch("/article/upload", {
                        method: 'POST',
                        body: formData
                    });
                    console.log("1")

                    const res = await response.json();

                    console.log()

                    if (res.data.filepath) {
                        link = {
                            href: res.data.filepath
                        };
                        console.log(0, link)
                    } else {
                        console.log(res.message);
                        return null;
                    }
                } catch (error) {
                    console.error(error.message);
                    return null;
                }

                console.log(1, link)
                return link
            };

            function get_data(e) {
                const _this = e.target;
                const elm = document.getElementById("input-form");
                let data = (_ => {
                    let obj = {
                        uid: _this.dataset.uid,
                        content: elm_editor.text.trim()
                    };
                    (new FormData(elm)).forEach((v, k) => {
                        if (k === "hashtag") {
                            v = v.replace(/^#/, "").replace(/\s#/g, ",");

                        };
                        obj[k] = v;
                    });

                    return obj;
                })();

                return data;
            };

            // * 新增文章
            async function article_create(e) {
                try {
                    const response = await fetch("/article/create", {
                        method: "POST",
                        body: JSON.stringify(get_data(e))
                    });
                    const result = await response.json() ?? {};

                    if (!response.ok) {
                        console.error(result.message);
                        return;
                    };
                    location.href = "/articles";
                } catch (err) {
                    console.err(err.message);
                };
            };

            // * 更新文章
            async function article_update(e) {
                try {
                    const response = await fetch("/article/update", {
                        method: "PATCH",
                        body: JSON.stringify(get_data(e))
                    });
                    const result = await response.json() ?? {};

                    if (!response.ok) {
                        console.error(result.message);
                        return;
                    };
                    location.href = "/articles";
                } catch (err) {
                    console.err(err.message);
                };
            };

            // * 刪除文章
            async function article_delete(e) {
                const _this = e.target;

                if (!confirm("DELETE?")) {
                    return;
                };

                try {
                    const response = await fetch("/article/delete", {
                        method: "DELETE",
                        body: JSON.stringify({
                            uid: _this.dataset.uid
                        })
                    });
                    const result = await response.json() ?? {};

                    if (!response.ok) {
                        console.error(result.message);
                        return;
                    };
                    location.href = "/articles";
                } catch (err) {
                    console.err(err.message);
                }
            };
        });
    </script>
</body>

</html>