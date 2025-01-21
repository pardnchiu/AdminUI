let textInputErrorTimer;

const textInput = e => {
    const _this = e.target;
    const parent = _this.parentElement.parentElement;
    const type = _this.dataset.type ?? _this.type ?? "text";
    const wrap = _this.dataset.wrap ?? "1";
    const force = _this.dataset.force ?? "1";
    const canWrap = !(wrap === "0");
    const isWrap = /\n/.test(_this.value);
    const isForce = force === "1";

    let max = _this.dataset.max;
    let min = _this.dataset.min;

    switch (type) {
        case "text":
            if (!canWrap && isWrap) {
                _this.value = _this.value.replace(/\n/g, "");
                parent.dataset.error = 1;

                clearTimeout(textInputErrorTimer);
                textInputErrorTimer = setTimeout(_ => {
                    parent.dataset.error = 0;
                }, 1000);
            };

            _this.nextElementSibling.innerHTML = _this.value.replace(/\n/g, '<br>');
            break;
        case "account":
            var regex = /[^\w]/g;

            if (isForce) {
                _this.value = _this.value.replace(/\s/g, "").replace(regex, "");
            };

            const isError = regex.test(_this.value);

            parent.dataset.error = isError ? 1 : 0;
            parent.dataset.message = isError ? "僅接受半形英文 / 數字 / 底線" : "";
            break;
        case "number":
            var regex = /[^\d\-\.]/g;

            if (isForce || max || min) {
                _this.value = _this.value.replace(/\s/g, "").replace(regex, "");
            };

            parent.dataset.error = regex.test(_this.value) ? 1 : 0

            break;
        case "email":
            var regex = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;

            if (!regex.test(_this.value)) {
                parent.dataset.error = 1;
                parent.dataset.message = "內容不符合EMAIL格式."

                clearTimeout(textInputErrorTimer);
                textInputErrorTimer = setTimeout(_ => {
                    parent.dataset.error = 0;
                    parent.dataset.message = "";
                }, 1000);
            };
            break;
        case "password":
            var regex = /[^\w\!\"\#\$\%\&\'\(\)\*\+\,\-\.\/\:\;\<\=\>\?\@\[\\\]\^\`\{\|\}\~\ ]/;

            if (isForce) {
                _this.value = _this.value.replace(/\s/g, "").replace(regex, "");
            };

            parent.dataset.error = regex.test(_this.value) ? 1 : 0
            parent.dataset.message = regex.test(_this.value) ? "內容包含不支持的字符." : "";
            break;
        default: break;
    };

    if (max == null && min == null) {
        return;
    };

    max = isNaN(max) ? null : parseFloat(max);
    min = isNaN(min) ? null : parseFloat(min);

    switch (type) {
        case "number":
            if ((/^\-/.test(_this.value) && _this.value.length === 1) || /\.$/.test(_this.value) || _this.value.length < 1) {
                return;
            };

            _this.value = Math.max(min, Math.min(max, parseFloat(_this.value)));
            break;
        default:
            if (max != null && _this.value.length > max) {
                _this.value = _this.value.slice(0, max);
            };

            var isMin = min != null && _this.value.length;

            if (parent.dataset.error === "1" && isMin) {
                parent.dataset.message = parent.dataset.message + ((_this.value.length < min) ? (" / 最小長度為 " + min) : "")
            }
            else if (isMin) {
                parent.dataset.error = (_this.value.length < min) ? 1 : 0
                parent.dataset.message = (_this.value.length < min) ? ("最小長度為 " + min) : ""
            }
            break;
    }
}
const hasgtagKeyup = e => {
    if (e.key !== "Enter") {
        return;
    };

    const _this = e.target;
    const regex = /[#＃\,，\n\ ]+([\w\u4e00-\u9fa5\u3105-\u3129\u31A0-\u31B7\u3040-\u30FF\u3130-\u318F\uAC00-\uD7AF]+)/g;
    let ary = (_this.value || "").match(regex) || _this.value.split(/\s/);
    let map = new Map();

    if (ary.length < 1) {
        return;
    }

    for (let i = 0, e = ary[i]; i < ary.length; i++, e = ary[i]) {
        const hashtag = e.replace(/[#＃\,，\n\ ]/g, "").slice(0, 24);

        if (hashtag.length < 2) {
            continue;
        };

        map.set(hashtag, 0);
    };

    let keys = Array.from(map.keys());

    if (keys.length > 0) {
        _this.value = `#${keys.join(" #")} #`.trim();
        _this.nextElementSibling.innerHTML = _this.value.replace(/\n/g, '<br>');
    }
    else {
        _this.value = "#"
        _this.nextElementSibling.innerHTML = "#";
    };
};