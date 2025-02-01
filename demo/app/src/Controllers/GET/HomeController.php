<?php

namespace App\Controllers\GET;

use App\Controllers\Controller;
use App\Models\AuthAdmin;
use App\Models\SQL;

class HomeController extends Controller
{
    private string $view = "Home";
    private string $key = "";

    public function __construct($params)
    {
        parent::__construct($params);

        $this->key = (string) ($_COOKIE["auth_admin_login_key"] ?? $_GET["key"] ?? "");
    }

    public function init()
    {
        $is_auth = AuthAdmin::check_jwt() != null;

        if (!$is_auth && $this->key == "") {
            http_response_code(404);
            exit();
        } else if (!$is_auth) {
            $auth_name = $this->check_auth();

            if ($auth_name == null) {
                http_response_code(404);
                exit();
            };

            $this->render(["auth_name" => $auth_name]);
            return;
        };

        $this->render(["is_auth" => true]);
    }

    public function check_auth()
    {
        $result = SQL::table("auth")
            ->select("name")
            ->where("md5(email)", $this->key)
            ->get();

        if (empty($result)) {
            return null;
        };

        return $result[0]["name"];
    }

    protected function render($data = [])
    {
        extract($data);

        ob_start();

        include get_view($this->view);

        echo ob_get_clean();
    }
};
