<?php

namespace App\Controllers\GET\Editor;

use App\Controllers\Controller;

class DocController extends Controller
{
    private string $view = "Editor/Doc";

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
            "path" => "/editor/doc/" . $target,
            "filepath" => "/" . $target,
            "text" => $text,
            "is_md" => check_file(["md"], $target)
        ]);

        ob_start();

        include get_view($this->view);

        echo ob_get_clean();
    }
}
