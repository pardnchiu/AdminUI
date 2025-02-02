<?php

namespace App\Controllers\GET\Data;

use App\Controllers\Controller;
use PD\Async;
use PD\SQL;

class EditController extends Controller
{
    private string $view = "Data/Edit";

    public function __construct($params)
    {
        parent::__construct($params);

        $this->check_auth();
    }

    public function init()
    {
        try {
            $tasks = [
                "data" => [
                    "method" => fn() => $this->select_article()
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
        $result = SQL::table("data")
            ->where("dismiss", "0")
            ->where("uid", $uid)
            ->get();

        if (empty($result)) {
            header("Location: /datas");
            exit();
        };

        return $result[0];
    }

    private function render($data = [])
    {
        extract([
            ...$data,
            "uid" => $this->params["uid"],
            "path" => "/datas/:uid/edit"
        ]);

        ob_start();

        include get_view($this->view);

        echo ob_get_clean();
    }
}
