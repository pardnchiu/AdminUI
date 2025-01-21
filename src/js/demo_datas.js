let demo_datas = {
    is_guest: false,
    login: {
        title: "Pardn Chiu",
        // 用於綁定 ':model'
        password: "",
    },
    title: "PARDN 管理後台",
    left: {
        is_body_left_min: getCookie("is_body_left_min") || 0,
        is_database_list: 0,
        is_database_edit: 0,
        is_demo_article_editor: 0,
        is_demo_folder: 0,
        is_demo_text: 0,
        is_demo_json: 0
    },
};