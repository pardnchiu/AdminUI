<!DOCTYPE html>
<html lang="zh-Hans-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "新增資料"; ?></title>
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
                    <?php echo "新增資料"; ?>
                </strong>
                <section></section>
            </header>
            <!--  -->
            <section class="system-page-data-editor">
                <section>
                    <!--  -->
                    <div>
                        <!--  -->
                        <div>
                            <span>資料內容</span>
                            <section>
                                <?php
                                if (isset($data)) {
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
                                        <i class="fa-solid fa-hard-drive"></i>
                                        儲存
                                    </button>
                                    HTML;
                                };
                                ?>
                            </section>
                        </div>
                        <!--  -->
                        <section>
                            <form id="input-form" class="system-component-form">
                                <label title="單行輸入欄位" data-hint="高度自增長輸入框 (不支持換行)">
                                    <section>
                                        <textarea name="single" placeholder="單行輸入欄位" data-required="1" data-type="text" data-wrap="0" data-max="24" @input="textInput"><?php echo $data["single"] ?? ""; ?></textarea>
                                        <pre><?php echo $data["single"] ?? ""; ?></pre>
                                    </section>
                                </label>
                                <label title="多行輸入欄位" data-hint="高度自增長輸入框 (支持換行)">
                                    <section>
                                        <textarea name="mutiple" placeholder="多行輸入欄位" data-type="text" data-wrap="1" data-max="128" @input="textInput"><?php echo $data["mutiple"] ?? ""; ?></textarea>
                                        <pre><?php echo $data["mutiple"] ?? ""; ?></pre>
                                    </section>
                                </label>
                                <label title="英文數字底線欄位" data-hint="僅接受半形英文 / 數字 / 底線 (此範例最小長度為 8 最大長度為 24)">
                                    <section>
                                        <input name="eng_num" placeholder="英文數字欄位" data-type="account" data-force="0" data-max="24" data-min="8" @input="textInput" value="<?php echo $data["eng_num"] ?? ""; ?>">
                                    </section>
                                </label>
                                <label title="數字欄位" data-hint="僅接受半形數字 (此範例為 -9999 ~ 99999 的數字範圍)">
                                    <section>
                                        <input name="number" placeholder="數字欄位" data-type="number" data-force="0" data-max="99999" data-min="-9999" @input="textInput" value="<?php echo $data["number"] ?? ""; ?>">
                                    </section>
                                </label>
                                <label title="信箱欄位" data-hint="自動檢查信箱格式">
                                    <section>
                                        <input name="email" placeholder="信箱欄位" data-type="email" data-force="0" data-max="1024" @input="textInput" value="<?php echo $data["email"] ?? ""; ?>">
                                    </section>
                                </label>
                                <label title="密碼欄位" data-hint="此範例最小長度為 8 最大長度為 24">
                                    <section>
                                        <input name="password" type="password" placeholder="密碼欄位" data-max="24" data-min="8" @input="textInput" value="<?php echo $data["password"] ?? ""; ?>">
                                    </section>
                                </label>
                                <label title="時間欄位">
                                    <section>
                                        <input name="date" type="datetime-local" placeholder="日期欄位" @input="textInput" value="<?php echo $data["date"] ?? ""; ?>">
                                    </section>
                                </label>
                                <label title="單選欄位">
                                    <section>
                                        <input title="選項1" name="radio" type="radio" value="選項1" <?php echo ($data["radio"] ?? "") === "0" ? "checked" : ""; ?> />
                                        <input title="選項2" name="radio" type="radio" value="選項2" <?php echo ($data["radio"] ?? "") === "1" ? "checked" : ""; ?> />
                                    </section>
                                </label>
                                <label title="多選欄位">
                                    <section>
                                        <?php $values = explode(",", $data["checkbox"] ?? ""); ?>
                                        <input title="選項1" name="checkbox" type="checkbox" value="選項1" <?php echo in_array("0", $values) ? "checked" : ""; ?> />
                                        <input title="選項2" name="checkbox" type="checkbox" value="選項2" <?php echo in_array("1", $values) ? "checked" : ""; ?> />
                                    </section>
                                </label>
                                <label title="選項欄位">
                                    <section>
                                        <select name="select">
                                            <option value="選項1" <?php echo ($data["select"] ?? "") === "選項1" ? "selected" : ""; ?> />選項1</option>
                                            <option value="選項2" <?php ($data["select"] ?? "") === "選項2" ? "selected" : ""; ?> />選項2</option>
                                            <option value="選項3" <?php ($data["select"] ?? "") === "選項3" ? "selected" : ""; ?> />選項3</option>
                                            <option value="選項4" <?php ($data["select"] ?? "") === "選項4" ? "selected" : ""; ?> />選項4</option>
                                            <option value="選項5" <?php ($data["select"] ?? "") === "選項5" ? "selected" : ""; ?> />選項5</option>
                                        </select>
                                    </section>
                                </label>
                                <label title="圖片欄位">
                                    <section>
                                        <input id="image-input" name="image" type="file" accept="image/jpeg, image/png, image/gif, image/webp">
                                    </section>
                                    <?php
                                    $image = $data["image"] ?? null;
                                    if ($image != null) {
                                        echo <<<HTML
                                        <img src="$image" style="max-width: 16rem;">
                                        HTML;
                                    };
                                    ?>
                                </label>
                            </form>
                        </section>
                    </div>
                </section>
            </section>
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
                    create: data_create,
                    update: data_update,
                    delete: data_delete
                },
                when: {
                    rendered: _ => {
                        loginCheck();
                    },
                    beforeUpdate: _ => {
                        // * 停用畫面更新
                        return false;
                    }
                }
            });

            // * 上傳圖片
            async function data_upload() {
                let link;

                try {
                    const file = document.getElementById("image-input").files[0];
                    const allowedTypes = ["image/jpeg", "image/png", "image/gif", "image/webp"];

                    if (!allowedTypes.includes(file.type)) {
                        alert("只接受 JPG, PNG, GIF, WebP");
                        return null;
                    };

                    const data = new FormData();
                    data.append("image", file);

                    const response = await fetch("/data/upload", {
                        method: "POST",
                        body: data
                    });
                    const json = await response.json();

                    if (response.ok) {
                        link = json.data.filepath;
                    } else {
                        return null;
                    };
                } catch (err) {
                    console.error(err.message);
                    return null;
                };

                return link;
            };

            function get_data(e) {
                const _this = e.target;
                const elm = document.getElementById("input-form");
                let data = (_ => {
                    let obj = {
                        uid: _this.dataset.uid,
                    };
                    (new FormData(elm)).forEach((v, k) => {
                        if (k === "date" && v.trim().length > 0) {
                            v = toUTC_0(v);
                        };
                        obj[k] = v;
                    });

                    return obj;
                })();

                function toUTC_0(inputTime) {
                    let date = new Date(inputTime);
                    return date.toISOString().slice(0, 19).replace("T", " ");
                };

                data.checkbox = [...elm.querySelectorAll("input[name='checkbox']:checked")].map(e => e.value).join(",");

                return data;
            };

            // * 新增資料
            async function data_create(e) {
                let link;
                let data = get_data(e);

                if (document.getElementById("image-input").files.length > 0) {
                    link = await data_upload();
                };

                data.image = link;

                try {
                    const response = await fetch("/data/create", {
                        method: "POST",
                        body: JSON.stringify(data)
                    });

                    if (!response.ok) {
                        console.error(result.message);
                        return;
                    };
                    const result = await response.json() ?? {};

                    location.href = "/datas";
                } catch (err) {
                    console.error(err.message);
                };
            };

            // * 更新資料
            async function data_update(e) {
                let link;
                let data = get_data(e);

                if (document.getElementById("image-input").files.length > 0) {
                    link = await data_upload();
                };

                data.image = link;

                try {
                    const response = await fetch("/data/update", {
                        method: "PATCH",
                        body: JSON.stringify(data)
                    });

                    if (!response.ok) {
                        console.error(result.message);
                        return;
                    };
                    const result = await response.json() ?? {};

                    location.href = "/datas";
                } catch (err) {
                    console.error(err.message);
                };
            };

            // * 刪除資料
            async function data_delete(e) {
                const _this = e.target;

                if (!confirm("DELETE?")) {
                    return;
                };

                try {
                    const response = await fetch("/data/delete", {
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