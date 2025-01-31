function encodeToSafeBase64(obj) {
    const str = JSON.stringify(obj);
    const utf8 = new TextEncoder().encode(str);
    return btoa(String.fromCharCode(...utf8))
        .replace(/=/g, "")
        .replace(/\+/g, "-")
        .replace(/\//g, "_");
};