<?php

namespace GET;

use Controllers\Controller;

class DataAddController extends Controller
{
    private string $view = "DataEdit";

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

        include GET_VIEW($this->view);

        echo ob_get_clean();
    }
}
