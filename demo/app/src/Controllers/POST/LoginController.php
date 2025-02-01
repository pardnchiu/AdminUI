<?php

namespace App\Controllers\POST;

use App\Models\AuthAdmin;
use App\Models\SQL;

class LoginController
{
    private array $post_data = [];

    public function __construct()
    {
        $this->post_data = $this->get_post_data();
    }

    public function init()
    {
        $this->login();
    }

    private function get_post_data(): array
    {
        $input = file_get_contents("php://input");
        $json = json_decode($input, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        };

        return $json;
    }

    private function login()
    {
        try {
            if (!isset($_COOKIE["auth_admin_login_key"])) {
                throw new \Exception("Login key not exists.");
            } else if (!isset($this->post_data["password"])) {
                throw new \Exception("Password not exist.");
            };

            $auth = $this->select_auth($_COOKIE["auth_admin_login_key"]);
            $password = $this->post_data["password"];

            if (!$auth) {
                throw new \Exception('找不到該管理員帳號');
            } else if (md5($password) !== $auth['password']) {
                throw new \Exception('密碼錯誤');
            };

            AuthAdmin::add_jwt([
                "sn" => $auth["sn"],
                "email" => $auth["email"],
                "name" => $auth["name"]
            ]);

            Success([
                "sn" => $auth["sn"],
                "email" => $auth["email"]
            ]);
        } catch (\Exception $err) {
            Error($err->getMessage(), 401);
        };
    }

    private function select_auth($login_key)
    {
        $result = SQL::table("auth")
            ->where("md5(email)", $login_key)
            ->where("dismiss", 0)
            ->get();


        if (empty($result)) {
            return null;
        };

        return $result[0];
    }
}
