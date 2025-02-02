<?php

namespace App\Controllers\GET\Article;

use App\Controllers\Controller;
use PD\Async;
use PD\SQL;

class EditController extends Controller
{
    private string $view = "Article/Edit";

    public function __construct($params)
    {
        parent::__construct($params);

        $this->check_auth();
    }

    public function init()
    {
        try {
            $tasks = [
                "article" => [
                    "method" => fn() => $this->select_article()
                ],
                "topics" => [
                    "method" => fn() => $this->get_json()
                ]
            ];
            Async::run($tasks)
                ->then(fn($result) => $this->render($result))
                ->catch(fn($err) => throw $err);
        } catch (\Exception $err) {
            PrintError($err->getMessage());
        };
    }

    private function select_article()
    {
        $uid = $this->params["uid"];
        $result = SQL::table("article")
            ->where("dismiss", "0")
            ->where("uid", $uid)
            ->get();

        if (empty($result)) {
            header("Location: /articles");
            exit();
        };

        return $result[0];
    }

    private function get_json()
    {
        $filepath = get_path("/storage/json/article_topic.json");
        $topics = get_json_from($filepath) ?? [];

        return $topics;
    }

    private function render($data = [])
    {
        extract([
            ...$data,
            "uid" => $this->params["uid"],
            "path" => "/articles/:uid/edit"
        ]);

        ob_start();

        include get_view($this->view);

        echo ob_get_clean();
    }
}
