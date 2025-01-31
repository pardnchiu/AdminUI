<?php

namespace POST;

use Controllers\Controller;
use Models\SQL;

class DataCreateController extends Controller
{
    public function __construct($params)
    {
        parent::__construct($params);

        $this->check_auth();
    }

    public function init()
    {
        $data = $this->post_data;

        switch (true) {
            case !isset($data["single"]) || strlen(trim($data["single"])) < 1:
                ERROR("單行輸入: 不得為空", 400);
                break;
            case strlen(trim($data["single"])) > 24:
                ERROR("單行輸入: 最多 24 個字", 400);
                break;
            case strlen(trim($data["mutiple"])) > 128:
                ERROR("多行輸入: 最多 128 個字", 400);
                break;
            case strlen(trim($data["eng_num"])) > 48:
                ERROR("英文數字底線: 最多 24 個字", 400);
                break;
            case $data["number"] > 99999:
                ERROR("數字: 最大 99999", 400);
                break;
            case strlen(trim($data["email"])) > 1024:
                ERROR("信箱: 最多 1024 個字", 400);
                break;
            case strlen(trim($data["password"])) > 24:
                ERROR("密碼: 最多 24 個字", 400);
                break;
            case strlen(trim($data["date"])) > 1024:
                ERROR("時間", 400);
                break;
            case isset($data["radio"]) && strlen(trim($data["radio"])) > 24:
                ERROR("單選: 最多 24 字", 400);
                break;
            case strlen(trim($data["checkbox"])) > 512:
                ERROR("多選: 最多 512 字", 400);
                break;
            case strlen(trim($data["select"])) > 24:
                ERROR("選項: 最多 24 字", 400);
                break;
            case isset($data["image"]) && strlen(trim($data["image"])) > 1024:
                ERROR("圖片: 最多 1024 字", 400);
                break;
            default:
                $this->insert_article($data);
        };
    }

    private function insert_article($data)
    {
        $id = SQL::table("data")
            ->insertGetId([
                "single" => $data["single"],
                "mutiple" => $data["mutiple"] ?: null,
                "eng_num" => $data["eng_num"] ?: null,
                "number" => $data["number"] ?: null,
                "email" => $data["email"] ?: null,
                "password" => $data["password"] ?: null,
                "date" => $data["date"] ?: null,
                "radio" => $data["radio"] ?? null,
                "checkbox" => $data["checkbox"] ?: null,
                "select" => $data["select"] ?: null,
                "image" => $data["image"] ?? null
            ]);

        if ($id == null) {
            ERROR("新增失敗", 500);
            return;
        };

        SUCCESS(["id" => $id], 201);
    }
}
