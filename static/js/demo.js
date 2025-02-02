

let demo_datas = {
    is_guest: !Boolean(getCookie("is_auth") ?? 0),
    login: {
        title: "Pardn Chiu",
        // 用於綁定 ':model'
        password: "",
    },
    title: "AdminUI 靜態範例",
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

// * 純範例用，請直接透過後端實現
const demo_events = {
    auth_login: e => {
        e.target.parentElement.dataset.show = 1;

        addCookie("is_auth", 1);

        setTimeout(() => {
            location.reload();
        }, 500);
    },
    logout: e => {
        addCookie("is_auth", 0);
        location.reload();
    },
};