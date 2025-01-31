<?php

namespace POST;

use Uploader\Image;

class ArticleImageController
{

    public function __construct() {}

    public function init()
    {
        if (!isset($_FILES["image"])) {
            ERROR("No files to upload.", 400);
            return;
        };

        if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
            ERROR("Uploaded error.", 500);
            return;
        };

        $result = Image::upload($_FILES["image"], "/storage/image/articles/");

        if ($result == null) {
            ERROR("Upload: Failed.", 500);
        } else {
            SUCCESS($result, 200);
        };
    }
}
