let page;

const system_events = {
    body_left_show: e => {
        const dom_target = document.querySelector("section.system-block-body-left");

        if (dom_target == null) {
            return;
        };

        dom_target.dataset.show = parseInt(dom_target.dataset.show) ? 0 : 1;
    },
    body_left_type: e => {
        const dom_target = document.querySelector("section.system-block-body-left");

        if (dom_target == null) {
            return;
        };

        const is_min = parseInt(dom_target.dataset.min);
        dom_target.dataset.min = is_min ? 0 : 1;
        addCookie("is_body_left_min", is_min ? 0 : 1)
    },
    tab_show: function (e) {
        const dom_this = e.target;
        const dom_parent = dom_this.parentElement;
        const is_show = parseInt(dom_this.dataset.show);
        const is_child_selected = dom_parent.querySelector("a[data-selected='1']") != null;

        if (is_child_selected && (isNaN(is_show) || is_show)) {
            this.dataset.show = 0;
        } else if (is_show) {
            this.dataset.show = 0;
        } else {
            this.dataset.show = 1;
        };
    },
};
