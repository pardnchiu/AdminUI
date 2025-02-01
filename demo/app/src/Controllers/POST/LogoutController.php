<?php

namespace App\Controllers\POST;

use App\Models\AuthAdmin;

class LogoutController
{
    public function __construct() {}

    public function init()
    {
        $this->removeCookies();
    }

    private function removeCookies()
    {
        try {
            AuthAdmin::remove_jwt();

            Success();
        } catch (\Exception $err) {
            Error($err->getMessage(), 401);
        }
    }
}
