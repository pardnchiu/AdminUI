<?php

return [
    "/login"                    => GET\LoginController::class,
    "/"                         => GET\HomeController::class,
    "/articles"                 => GET\ArticleListController::class,
    "/articles/:uid/edit"       => GET\ArticleEditController::class,
    "/article/add"              => GET\ArticleAddController::class,
    "/datas"                    => GET\DataListController::class,
    "/datas/:uid/edit"          => GET\DataEditController::class,
    "/data/add"                 => GET\DataAddController::class,
    "/document/:target"         => GET\DocumentController::class,
    "/storage/image/:filename"  => GET\ImageController::class,
];
