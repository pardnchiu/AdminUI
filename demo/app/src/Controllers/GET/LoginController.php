<?php

namespace App\Controllers\GET;

use App\Controllers\Controller;
use App\Models\AuthAdmin;

class LoginController extends Controller
{
    private string $view = "Login";

    public function __construct($params)
    {
        parent::__construct($params);
    }

    public function init()
    {
        if (AuthAdmin::check_jwt() != null) {
            header("Location: /");
            exit();
        };

        $this->render();
    }

    protected function render($data = [])
    {
        extract($data);

        ob_start();

        include get_view($this->view);

        echo ob_get_clean();
    }
};
