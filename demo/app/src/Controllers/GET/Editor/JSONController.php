<?php

namespace App\Controllers\GET\Editor;

use App\Controllers\Controller;

class JSONController extends Controller
{
    private string $view = "Editor/JSON";

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
        $target = $this->params["target"];

        if (preg_match("/^storage/", $target)) {
            $filepath = get_path("/" . $target);
            $text = get_file($filepath);
        };

        extract([
            "path" => "/editor/json/" . $target,
            "filepath" => "/" . $target,
            "text" => $text
        ]);

        ob_start();

        include get_view($this->view);

        echo ob_get_clean();
    }
}
