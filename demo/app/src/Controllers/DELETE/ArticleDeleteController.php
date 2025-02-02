<?php

namespace App\Controllers\DELETE;

use App\Controllers\Controller;
use PD\SQL;

class ArticleDeleteController extends Controller
{
    public function __construct($params)
    {
        parent::__construct($params);

        $this->check_auth();
    }

    public function init()
    {
        $data = $this->post_data;

        if (!isset($data["uid"]) || strlen(trim($data["uid"])) < 3 || strlen(trim($data["uid"])) > 5) {
            Error("UID: 不存在", 400);
            return;
        };

        $this->delete_article($data);
    }

    private function delete_article($data)
    {
        $result = SQL::table("article")
            ->where("dismiss", 0)
            ->where("uid", $data["uid"])
            ->update([
                "dismiss" => 1
            ]);

        if ($result["affected_rows"] === 0) {
            Error("刪除失敗", 500);
            return;
        };

        Success();
    }
}
