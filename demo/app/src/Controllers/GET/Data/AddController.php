<?php

namespace App\Controllers\GET\Data;

use App\Controllers\Controller;

class AddController extends Controller
{
    private string $view = "Data/Edit";

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
        extract([
            "path" => "/data/add"
        ]);

        ob_start();

        include get_view($this->view);

        echo ob_get_clean();
    }
}
