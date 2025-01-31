<?php

namespace GET;

use Controllers\Controller;

class ArticleAddController extends Controller
{
    private string $view = "ArticleEdit";

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
        $filepath = PATH("/src/Configs/article_topic.json");
        $topics = GET_JSON($filepath) ?? [];

        extract([
            "path" => "/article/add",
            "topics" => $topics
        ]);

        ob_start();

        include GET_VIEW($this->view);

        echo ob_get_clean();
    }
}
