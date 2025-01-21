

let demo_datas = {
    is_guest: !Boolean(getCookie("is_auth") ?? 0),
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

const demo_events = {
    show: e => {
        const _this = e.target;
        const isShow = _this.parentElement.dataset.show === "1";
        _this.className = `fa-solid ${isShow ? "fa-eye-slash" : "fa-eye"}`;
        // this.$pre(0).$child(0).type = isShow ? "password" : "text";
        _this.previousElementSibling.children[0].type = isShow ? "password" : "text";
        _this.parentElement.dataset.show = isShow ? 0 : 1;
    },
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