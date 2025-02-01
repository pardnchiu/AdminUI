<?php

namespace App\Controllers\GET\Viewer;

use App\Controllers\Controller;

class MDController extends Controller
{
    private string $view = "Viewer/MD";

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
        } else if ($target === "readme") {
            $filepath = get_path("/README.md");
            $text = get_file($filepath);
            $target = "README.md";
        } else if ($target === "license") {
            $filepath = get_path("/LICENSE");
            $text = get_file($filepath);
            $target = "LICENSE";
        }

        extract([
            "path" => "/viewer/md/" . $target,
            "filepath" => "/" . $target,
            "text" => $text
        ]);

        ob_start();

        include get_view($this->view);

        echo ob_get_clean();
    }
}
