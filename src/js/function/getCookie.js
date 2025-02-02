function getCookie(targetKey = "") {
    targetKey = String(targetKey).trim();

    if (typeof targetKey !== "string" || targetKey.length < 1) {
        return;
    };

    const regexp = new RegExp(targetKey + "=([^ ;]+)?");
    const match = document.cookie.match(regexp) || [];
    const length = match.length;

    let targetValue = match[length - 1];

    if (length < 1 || targetValue == null) {
        return;
    };

    targetValue = decodeURIComponent(targetValue);

    try {
        return JSON.parse(targetValue)
    }
    catch (err) {
        return targetValue;
    };
};