<?php

namespace App\Controllers;

use App\Models\AuthAdmin;

class Controller
{
    protected array $post_data = [];
    protected array $params = [];

    public function __construct($params)
    {
        $this->params = $params ?? [];
        $this->post_data = $this->get_post_data();
    }

    protected function get_post_data(): array
    {
        $input = file_get_contents("php://input");
        $json = json_decode($input, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        };

        return $json;
    }

    protected function check_auth()
    {
        $is_auth = AuthAdmin::check_jwt() != null;

        if (!$is_auth) {
            http_response_code(404);
            exit();
        };
    }
}
