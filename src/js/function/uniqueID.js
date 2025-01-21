const keys = "abcdefghijklmnopqrstuvwxyz0123456789";
let keyMap = new Map();

function uniqueID(length = 64) {
    let key = "";

    for (let i = 0; i < length; i++) {
        key += keys[_charAt]($Math[_floor]($Math[_random]() * 36));
    };

    return key
};