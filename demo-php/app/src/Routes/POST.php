<?php

return [
    "/login"          => POST\LoginController::class,
    "/logout"         => POST\LogoutController::class,
    "/article/upload" => POST\ArticleImageController::class,
    "/article/create" => POST\ArticleCreateController::class,
    "/data/upload"    => POST\DataImageController::class,
    "/data/create"    => POST\DataCreateController::class,
];
