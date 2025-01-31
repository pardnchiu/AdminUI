<?php

namespace POST;

use Models\AuthAdmin;

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

            SUCCESS();
        } catch (\Exception $err) {
            ERROR($err->getMessage(), 401);
        }
    }
}
