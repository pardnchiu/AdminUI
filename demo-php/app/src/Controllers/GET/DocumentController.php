<?php

namespace GET;

use Controllers\Controller;

class DocumentController extends Controller
{
    private string $view = "Document";

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

        if ($target === "readme") {
            $filepath = PATH("/README.md");
            $text = GET_TEXT($filepath);
            $path = "/document/readme";
        } else if ($target === "license") {
            $filepath = PATH("/LICENSE");
            $text = GET_TEXT($filepath);
            $path = "/document/license";
        }

        extract([
            "path" => $path,
            "text" => $text
        ]);

        ob_start();

        include GET_VIEW($this->view);

        echo ob_get_clean();
    }
}
