<!DOCTYPE html>
<html lang="zh-Hans-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>資料列表範例</title>
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
                <strong>資料列表範例</strong>
                <section></section>
            </header>
            <!-- 資料庫 -->
            <section class="system-page-data-list">
                <section>
                    <details open>
                        <summary>
                            <span>篩選條件 <i class="fa-solid fa-caret-right"></i></span>
                            <section>
                                <!-- 可以放按鈕 -->
                                <button @click="add_filter">
                                    <i class="fa-solid fa-circle-plus"></i>
                                    添加
                                </button>
                                <button @click="clear_filter">
                                    <i class="fa-solid fa-eraser"></i>
                                    清除
                                </button>
                                <button @click="send_filter">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    送出
                                </button>
                            </section>
                        </summary>
                        <section id="filter-body" data-row="1">
                            <?php
                            foreach ($filter as $value) {
                                echo <<<HTML
                                <form>
                                <button type="button" @click="remove_filter">
                                    <i class="fa-solid fa-circle-minus"></i>
                                </button>
                                <select name="key" @change="key_change">
                                HTML;

                                foreach ($table_head as $k => $v) {
                                    $selected = ($k == $value["key"] ? "selected" : "");
                                    echo "<option value='$k' $selected>$v</option>";
                                };

                                echo <<<HTML
                                </select>
                                <select name="compare" @change="compare_change">
                                HTML;

                                foreach ($compare as $k => $v) {
                                    $selected = ($v == $value["compare"] ? "selected" : "");
                                    echo "<option value='$v' $selected>$k</option>";
                                };

                                $v = $value["value"];

                                echo <<<HTML
                                </select>
                                <input type="text" name="value" placeholder="值" value="$v" @change="value_change" @keydown="value_keydown">
                                </form>
                                HTML;
                            }
                            ?>
                        </section>
                    </details>
                    <!-- 列表 -->
                    <section>
                        <table data-head="1">
                            <thead>
                                <tr>
                                    <?php
                                    foreach ($table_head as $key => $value) {
                                        if (($_GET["order"] ?? "") === $key) {
                                            $arrow = '<i class="fa-solid fa-arrow-' . (($_GET["direct"] ?? "DESC") === "DESC" ? "up" : "down") . '-a-z"></i>';
                                            echo "<th data-key='$key' @click='order_by' :background-color='#d1dffa'>$value $arrow</th>";
                                        } else {
                                            echo "<th data-key='$key' @click='order_by'>$value</th>";
                                        };
                                    };
                                    ?>
                                    <th>其他</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($data_list as $value) {
                                    $list = implode("</td><td>", $value);
                                    $uid = $value[1];
                                    echo <<<HTML
                                    <tr>
                                        <td>$list</td>
                                        <td>
                                            <button data-uid="$uid" @click="edit">編輯</button>
                                            <button data-uid="$uid" @click="delete" class="alert">刪除</button>
                                        </td>
                                    </tr>
                                    HTML;
                                };
                                ?>
                            </tbody>
                        </table>
                    </section>
                </section>
                <!-- 按鈕 -->
                <footer>
                    <section>
                        <?php
                        $query_params = $_GET;

                        if ($page > 1) {
                            $query_params["page"] = $page - 1;
                            echo "<a href='?" . http_build_query($query_params) . "'>上一頁</a>";
                        };

                        for ($i = 0; $i < $page_max; $i++) {
                            $query_params["page"] = $i + 1;

                            if ($i == $page - 1) {
                                echo "<a user-select='1'>" . ($i + 1) . "</a>";
                            } else {
                                echo "<a href='?" . http_build_query($query_params) . "' user-select='0'>" . ($i + 1) . "</a>";
                            };
                        };

                        if ($page < $page_max - 1) {
                            $query_params["page"] = $page + 1;
                            echo "<a href='?" . http_build_query($query_params) . "'>下一頁</a>";
                        };
                        ?>
                    </section>
                    <section>
                        <p user-select="0">顯示</p>
                        <select name="" id="">
                            <option value="10">10</option>
                            <option value="50">50</option>
                        </select>
                        <p user-select="0">結果</p>
                    </section>
                </footer>
            </section>
        </section>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", _ => {
            const listHead = <?php echo json_encode($table_head); ?>;
            const compare = <?php echo json_encode($compare); ?>;

            let timer;

            let url = new URL(location.href);
            let query = url.searchParams;
            let filter = query.get("filter");

            if (filter != null) {
                filter = JSON.parse(decodeFromSafeBase64(filter));
            };

            filter = filter ?? [];

            page = new QUI({
                id: "body",
                data: {
                    title: "AdminUI 後台模板",
                    filter: filter
                },
                event: {
                    ...system_events,
                    ...auth_events,
                    // * 新增篩選項目
                    add_filter: e => {
                        document.getElementById("filter-body").appendChild(
                            createElement("form", [
                                addEvent({
                                    dom: createElement("button", {
                                        type: "button"
                                    }, [
                                        createElement("i.fa-solid.fa-circle-minus")
                                    ]),
                                    onclick: page.event.remove_filter
                                }),
                                addEvent({
                                    dom: createElement("select", {
                                        name: "key"
                                    }, [
                                        ...Object.keys(listHead).map(e => {
                                            return createElement("option", {
                                                value: e
                                            }, listHead[e])
                                        })
                                    ]),
                                    onchange: page.event.key_change
                                }),
                                addEvent({
                                    dom: createElement("select", {
                                        name: "compare"
                                    }, [
                                        ...Object.keys(compare).map(e => {
                                            return createElement("option", {
                                                value: compare[e]
                                            }, e)
                                        })
                                    ]),
                                    onchange: page.event.compare_change
                                }),
                                addEvent({
                                    dom: createElement("input", {
                                        name: "value",
                                        placeholder: "值"
                                    }),
                                    onchange: page.event.value_change,
                                    onkeydown: page.event.value_keydown
                                }),
                            ])
                        );
                        page.data.filter.push({
                            key: Object.keys(listHead)[0],
                            compare: Object.values(compare)[0],
                            value: ""
                        });
                    },
                    remove_filter: e => {
                        const _this = e.target;
                        const index = Array.prototype.indexOf.call(e.target.parentElement.parentElement.children, e.target.parentElement);

                        _this.parentElement.remove();
                        page.data.filter.splice(index, 1);
                    },
                    // * 清空篩選項目
                    clear_filter: e => {
                        // document.getElementById("filter-body").innerHTML = "";
                        // page.data.filter = [];
                        location.href = "/datas";
                    },
                    // * 送出篩選
                    send_filter: e => {
                        let result = page.data.filter.filter(e => e.key.length && e.compare.length);
                        let filter = encodeToSafeBase64(JSON.stringify(result));
                        let url = new URL(location.href);
                        let query = url.searchParams;

                        query.set("filter", filter);
                        query.delete("page");

                        url.search = query.toString();
                        location.href = url;
                    },
                    // * 排序方式
                    order_by: e => {
                        const _this = e.target;
                        const key = _this.dataset.key;

                        let url = new URL(location.href);
                        let query = url.searchParams;
                        let order = query.get("order") ?? "";
                        let direct = query.get("direct") ?? "ASC";

                        if (order !== key) {
                            query.set("order", key);
                            query.set("direct", "ASC");
                        } else if (direct === "ASC") {
                            query.set("direct", "DESC");
                        } else {
                            query.delete("order");
                            query.delete("direct");
                        };

                        url.search = query.toString();
                        location.href = url;
                    },
                    key_change: e => {
                        let index = Array.prototype.indexOf.call(e.target.parentElement.parentElement.children, e.target.parentElement);

                        let obj = {};
                        new FormData(e.target.parentElement).forEach((value, key) => {
                            obj[key] = value;
                        });

                        page.data.filter[index] = obj;
                    },
                    compare_change: e => {
                        let index = Array.prototype.indexOf.call(e.target.parentElement.parentElement.children, e.target.parentElement);

                        let obj = {};
                        new FormData(e.target.parentElement).forEach((value, key) => {
                            console.log(key)
                            obj[key] = value;
                        });

                        page.data.filter[index] = obj;

                        console.log(obj, page.data.filter);
                    },
                    value_change: e => {
                        let index = Array.prototype.indexOf.call(e.target.parentElement.parentElement.children, e.target.parentElement);

                        let obj = {};
                        new FormData(e.target.parentElement).forEach((value, key) => {
                            obj[key] = value;
                        });

                        page.data.filter[index] = obj;
                    },
                    value_keydown: e => {
                        if (e.key === "Enter") {
                            e.preventDefault();
                        }
                    },
                    edit: e => {
                        const _this = e.target;
                        const uid = _this.dataset.uid;
                        location.href = "/datas/" + uid + "/edit";
                    },
                    delete: data_delete,
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
        });

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
                location.reload();
            } catch (err) {
                console.err(err.message);
            }
        };
    </script>
</body>

</html>