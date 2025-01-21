function addCookie(key, body, expire) {

    if (!{ string: 1, number: 1 }[typeof key] || String(key).trim().length < 1 || body == null) {
        return;
    };

    key = encodeURIComponent(key);
    expire = (typeof expire === "number" ? expire : 3600) * 1000;

    const now_date = Date.now();
    const date = new Date(now_date + expire);

    body = typeof body === "object" ? JSON.stringify(body).trim() : String(body).trim();
    body = encodeURIComponent(body);

    document.cookie = `${key}=${body}; expires=${date.toUTCString()}; path=/;`;

    return document.cookie;
};