<?php

namespace App\Controllers\PATCH;

use App\Controllers\Controller;
use App\Models\SQL;

class DataUpdateController extends Controller
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
            case !isset($data["uid"]) || strlen(trim($data["uid"])) < 3 || strlen(trim($data["uid"])) > 5:
                Error("uid: 不存在", 400);
                break;
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
                $this->update_article($data);
        };
    }

    private function update_article($data)
    {
        PrintDebug($data);
        $ary = [
            "single" => $data["single"],
            "mutiple" => strlen($data["mutiple"]) < 1 ? null : $data["mutiple"],
            "eng_num" => strlen($data["eng_num"]) < 1 ? null : $data["eng_num"],
            "number" => strlen($data["number"]) < 1 ? null : $data["number"],
            "email" => strlen($data["email"]) < 1 ? null : $data["email"],
            "password" => strlen($data["password"]) < 1 ? null : $data["password"],
            "date" => strlen($data["date"]) < 1 ? null : $data["date"],
            "radio" => $data["radio"] ?? null,
            "checkbox" => strlen($data["checkbox"]) < 1 ? null : $data["checkbox"],
            "select" => strlen($data["select"]) < 1 ? null : $data["select"],
            "updated" => "CURRENT_TIMESTAMP"
        ];
        if (isset($data["image"])) {
            $ary["image"] = $data["image"];
        };
        $result = SQL::table("data")
            ->where("dismiss", 0)
            ->where("uid", $data["uid"])
            ->update($ary);

        if ($result["affected_rows"] === 0) {
            Error("更新失敗", 500);
            return;
        };

        Success();
    }
}
