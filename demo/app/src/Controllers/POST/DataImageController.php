<?php

namespace App\Controllers\POST;

use App\Models\Uploader\Image;

class DataImageController
{

    public function __construct() {}

    public function init()
    {
        if (!isset($_FILES["image"])) {
            Error("未提供圖片", 400);
            return;
        };

        if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
            Error("上傳失敗", 500);
            return;
        };

        $result = Image::upload($_FILES["image"], "/storage/image/datas/");

        if ($result == null) {
            Error("上傳失敗", 500);
        } else {
            Success($result, 201);
        };
    }
}
