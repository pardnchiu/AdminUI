<?php

namespace App\Controllers\POST;

use App\Controllers\Controller;
use App\Models\SQL;

class ArticleCreateController extends Controller
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
            case !isset($data["title"]) || strlen(trim($data["title"])) < 3:
                Error("標題: 至少 3 個字", 400);
                break;
            case strlen(trim($data["content"])) < 16:
                Error("內容: 至少 16 個字", 400);
                break;
            case strlen(trim($data["title"])) > 48:
                Error("標題: 最多 48 個字", 400);
                break;
            case strlen(trim($data["subtitle"])) > 64:
                Error("副標題: 最多 64 個字", 400);
                break;
            case strlen(trim($data["topic"])) > 24:
                Error("分類: 最多 24 個字", 400);
                break;
            case strlen(trim($data["hashtag"])) > 1024:
                Error("標籤: 最多 1024 個字", 400);
                break;
            case strlen(trim($data["seo_title"])) > 1024:
                Error("SEO 標題: 最多 128 個字", 400);
                break;
            case strlen(trim($data["seo_description"])) > 256:
                Error("SEO 描述: 最多 256 個字", 400);
                break;
            default:
                $this->check_topic_new($data);
                $this->insert_article($data);
        };
    }

    private function check_topic_new($data)
    {
        if (!isset($data["topic_new"]) || strlen(trim($data["topic_new"])) < 1) {
            return;
        };

        $filepath = get_path("/storage/json/article_topic.json");
        $topics = get_json_from($filepath);

        if ($topics == null) {
            save_json_to($filepath, [$data["topic_new"]]);
            return;
        };

        $topics = array_filter($topics, function ($topic) use ($data) {
            return $topic !== $data["topic_new"];
        });

        $topics[] = $data["topic_new"];
        sort($topics);

        save_json_to($filepath, $topics);
    }

    private function insert_article($data)
    {
        $id = SQL::table("article")
            ->insertGetId([
                "slug" => $data["slug"],
                "title" => $data["title"],
                "subtitle" => $data["subtitle"],
                "topic" => $data["topic"] ?: $data["topic_new"],
                "hashtag" => $data["hashtag"],
                "seo_title" => $data["seo_title"],
                "seo_description" => $data["seo_description"],
                "content" => $data["content"]
            ]);

        if ($id == null) {
            Error("新增失敗", 500);
            return;
        };

        Success(["id" => $id], 201);
    }
}
