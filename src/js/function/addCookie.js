function addCookie(targetKey = "", body, expireSec) {
    targetKey = String(targetKey).trim();

    if (typeof targetKey !== "string" || targetKey.length < 1 || body == null) {
        return;
    };

    targetKey = encodeURIComponent(targetKey);
    expireSec = (typeof expireSec === "number" ? expireSec : 3600) * 1000;

    const dateNow = Date.now();
    const date = new Date(dateNow + expireSec);

    body = encodeURIComponent(
        typeof body === "object"
            ? JSON.stringify(body).trim()
            : String(body).trim()
    );

    document.cookie = `${targetKey}=${body}; expires=${date.toUTCString()}; path=/`;

    return document.cookie;
};