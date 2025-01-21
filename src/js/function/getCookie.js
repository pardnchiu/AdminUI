function getCookie(key) {
    if (!{ string: 1, number: 1 }[typeof key] || String(key).trim().length < 1) {
        return;
    };

    const key_regexp = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)');
    const match_results = document.cookie.match(key_regexp) || [];
    const length = match_results.length;

    if (length < 1) {
        return;
    };

    let target_value = match_results[1];

    target_value = decodeURIComponent(target_value);

    try {
        target_value = JSON.parse(target_value);
    } catch (err) {
        return
    };

    return target_value;
};