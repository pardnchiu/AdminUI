const auth_events = {
    show: e => {
        const _this = e.target;
        const isShow = _this.parentElement.dataset.show === "1";
        _this.className = `fa-solid ${isShow ? "fa-eye-slash" : "fa-eye"}`;
        _this.previousElementSibling.children[0].type = isShow ? "password" : "text";
        _this.parentElement.dataset.show = isShow ? 0 : 1;
    },
    auth_login: e => {
        if (page.data.password.length < 1) {
            return;
        };

        fetch("/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                key: getCookie("auth_admin_login_key"),
                password: page.data.password
            })
        }).then(response => {
            console.log(response.json())
            e.target.parentElement.dataset.show = 1;
            setTimeout(() => {
                location.reload();
            }, 1000);
        }).catch(error => {
            console.error("Error:", error);
        });
    },
    logout: e => {
        fetch("/logout", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            }
        }).then(response => {
            console.log(response.json())
            location.href = "/login"
        }).catch(error => {
            console.error("Error:", error);
        });
    }
};

function loginCheck() {
    if (getCookie("auth_admin") != null) {
        return;
    };

    //http://127.0.0.1/?key=1e667ecb9ef37340972e761897ce2d2c
    const url = new URL(location.href);
    const query = url.searchParams;
    const key = query.get("key");

    query.delete("key");

    url.search = query.toString();
    history.replaceState(null, '', url);

    if (key != null) {
        // 三分鐘之內重整都保持登入畫面
        addCookie("auth_admin_login_key", key, 180);
    };

    let timer = setInterval(() => {
        if (getCookie("auth_admin_login_key") != null) {
            return;
        };
        clearInterval(timer);

        document.body.innerHTML = "<span>登入已過期。</span>"
    }, 1000);
};