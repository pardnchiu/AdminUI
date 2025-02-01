<?php

namespace App\Controllers\GET\Viewer;

use App\Controllers\Controller;

class MediaController extends Controller
{
    private string $view = "Viewer/Media";

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

            if (!file_exists($filepath)) {
                http_response_code(404);
                exit;
            };
        };

        extract([
            "path" => "/editor/json/" . $target,
            "filepath" => "/" . $target,
            "is_media" => is_file_media($filepath)
        ]);

        ob_start();

        include get_view($this->view);

        echo ob_get_clean();
    }
}
