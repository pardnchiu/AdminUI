let page;

const system_events = {
    password_show: e => {
        const _this = e.target;
        const is_show = _this.parentElement.dataset.show === "1";
        _this.className = `fa-solid ${is_show ? "fa-eye-slash" : "fa-eye"}`;
        _this.previousElementSibling.children[0].type = is_show ? "password" : "text";
        _this.parentElement.dataset.show = is_show ? 0 : 1;
    },
    body_left_show: e => {
        const elm = document.querySelector("section.system-block-body-left");

        if (elm == null) {
            return;
        };

        elm.dataset.show = (parseInt(elm.dataset.show) ?? 0) ? 0 : 1;
    },
    body_left_type: e => {
        const elm = document.querySelector("section.system-block-body-left");

        if (elm == null) {
            return;
        };

        const is_min = parseInt(elm.dataset.min);
        elm.dataset.min = is_min ? 0 : 1;

        addCookie("is_body_left_min", is_min ? 0 : 1)
    },
    tab_show: e => {
        const _this = e.target;
        const elm_left = document.querySelector("section.system-block-body-left");
        const elm_parent = _this.parentElement;
        const show = parseInt(_this.dataset.show);
        const is_child_selected = elm_parent.querySelector("a[data-selected='1']") != null;
        const is_show = (is_child_selected && isNaN(show) || show) || show === 1;

        for (let e of [...elm_left.querySelectorAll("p[data-show='1']")]) {
            if (e === _this) {
                continue;
            };
            e.dataset.show = 0;
        };

        _this.dataset.show = is_show ? 0 : 1;
    },
};
