function getCookie(targetKey = "") {
    targetKey = String(targetKey).trim();

    if (typeof targetKey !== "string" || targetKey.length < 1) {
        return;
    };

    const keyRegexp = new RegExp(targetKey + "=([^ ;]+)?");
    const matchResults = document.cookie.match(keyRegexp) || [];
    const length = matchResults.length;

    let targetValue = matchResults[length - 1];

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