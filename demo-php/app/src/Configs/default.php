<?php

$IS_HTTPS = (isset($_SERVER['REDIRECT_HTTPS']) && $_SERVER['REDIRECT_HTTPS'] === "on") || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === "https");
$LOCATION_HREF = ($IS_HTTPS ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

function Response($data, int $statusCode = 200)
{
    header("Content-Type: application/json");
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function SUCCESS($data = null, $code = null)
{
    if ($code === null && $data === null) {
        $code = 200;
    };

    if (is_numeric($data)) {
        $code = $data;
        $data = null;
    };

    $response = ["message" => "成功"];

    if ($data !== null) {
        $response["data"] = $data;
    };

    Response($response, $code);
}

function ERROR($message, $code)
{
    Response(["message" => $message], $code);
}

function GET_TEXT($filepath)
{
    if (!file_exists($filepath)) {
        return;
    };

    $content = file_get_contents($filepath);

    return $content ?? "";
}

function GET_JSON($filepath)
{
    $content = GET_TEXT($filepath);
    $data = json_decode($content, true);

    if (!is_array($data)) {
        return;
    };

    return $data;
}

function CREATE_JSON($filepath, $data)
{
    file_put_contents($filepath, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

function GET_FRMO_BASE64($base64)
{
    try {
        // 2. 清理並還原 URL 安全字符
        $normalizedBase64 = str_replace(['-', '_'], ['+', '/'], trim($base64));

        // 3. 補齊填充字符
        $padding = strlen($normalizedBase64) % 4;
        if ($padding) {
            $normalizedBase64 .= str_repeat('=', 4 - $padding);
        }

        // 4. Base64 解碼
        $jsonString = base64_decode($normalizedBase64, true);
        if ($jsonString === false) {
            throw new \Exception("Base64 解碼失敗");
        }

        // 5. 移除多餘的引號（如果存在）
        if (preg_match('/^"(.*)"$/', $jsonString, $matches)) {
            $jsonString = stripslashes($matches[1]);  // 移除轉義字符
        }

        // 6. JSON 解碼
        $decodedData = json_decode($jsonString, true);

        // 7. 詳細的錯誤檢查
        $jsonError = json_last_error();

        if ($jsonError !== JSON_ERROR_NONE) {
            throw new \Exception("JSON 解碼錯誤: " . json_last_error_msg());
        }

        if ($decodedData === null) {
            throw new \Exception("解碼結果為 null");
        }
        if (!is_array($decodedData)) {
            throw new \Exception("解碼結果不是陣列，而是 " . gettype($decodedData));
        }

        return $decodedData;
    } catch (\Exception $e) {
        throw $e;
    }
}
