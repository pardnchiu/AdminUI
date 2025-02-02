<?php

namespace App\Controllers\POST;

use App\Controllers\Controller;
use PD\SQL;

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
                Error("單行輸入: 不得為空", 400);
                break;
            case strlen(trim($data["single"])) > 24:
                Error("單行輸入: 最多 24 個字", 400);
                break;
            case strlen(trim($data["mutiple"])) > 128:
                Error("多行輸入: 最多 128 個字", 400);
                break;
            case strlen(trim($data["eng_num"])) > 48:
                Error("英文數字底線: 最多 24 個字", 400);
                break;
            case $data["number"] > 99999:
                Error("數字: 最大 99999", 400);
                break;
            case strlen(trim($data["email"])) > 1024:
                Error("信箱: 最多 1024 個字", 400);
                break;
            case strlen(trim($data["password"])) > 24:
                Error("密碼: 最多 24 個字", 400);
                break;
            case strlen(trim($data["date"])) > 1024:
                Error("時間", 400);
                break;
            case isset($data["radio"]) && strlen(trim($data["radio"])) > 24:
                Error("單選: 最多 24 字", 400);
                break;
            case strlen(trim($data["checkbox"])) > 512:
                Error("多選: 最多 512 字", 400);
                break;
            case strlen(trim($data["select"])) > 24:
                Error("選項: 最多 24 字", 400);
                break;
            case isset($data["image"]) && strlen(trim($data["image"])) > 1024:
                Error("圖片: 最多 1024 字", 400);
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
            Error("新增失敗", 500);
            return;
        };

        Success(["id" => $id], 201);
    }
}
