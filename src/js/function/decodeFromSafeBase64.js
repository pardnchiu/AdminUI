function decodeFromSafeBase64(base64) {
    const str = base64.replace(/[-_]/g, e => (e === "-" ? "+" : "/"));
    const padding = str.length % 4;

    base64 = str + (padding ? "=".repeat(4 - padding) : "");

    const binary = atob(base64);
    const bytes = new Uint8Array([...binary].map(char => char.charCodeAt(0)));
    const json = new TextDecoder().decode(bytes);

    return JSON.parse(json);
};