<?php

namespace App\Controllers\GET\Article;

use App\Controllers\Controller;

class AddController extends Controller
{
    private string $view = "Article/Edit";

    public function __construct($params)
    {
        parent::__construct($params);

        $this->check_auth();
    }

    public function init()
    {
        $this->render();
    }

    private function render()
    {
        $filepath = get_path("/storage/json/article_topic.json");
        $topics = get_json_from($filepath) ?? [];

        extract([
            "path" => "/article/add",
            "topics" => $topics
        ]);

        ob_start();

        include get_view($this->view);

        echo ob_get_clean();
    }
}
