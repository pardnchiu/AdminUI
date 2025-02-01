<?php

return [
    "/login"          => App\Controllers\POST\LoginController::class,
    "/logout"         => App\Controllers\POST\LogoutController::class,
    "/article/upload" => App\Controllers\POST\ArticleImageController::class,
    "/article/create" => App\Controllers\POST\ArticleCreateController::class,
    "/data/upload"    => App\Controllers\POST\DataImageController::class,
    "/data/create"    => App\Controllers\POST\DataCreateController::class,
];
