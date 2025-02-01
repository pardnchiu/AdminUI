<?php

return [
    "/login"                    => App\Controllers\GET\LoginController::class,
    "/"                         => App\Controllers\GET\HomeController::class,
    "/articles"                 => App\Controllers\GET\Article\ListController::class,
    "/articles/:uid/edit"       => App\Controllers\GET\Article\EditController::class,
    "/article/add"              => App\Controllers\GET\Article\AddController::class,
    "/datas"                    => App\Controllers\GET\Data\ListController::class,
    "/datas/:uid/edit"          => App\Controllers\GET\Data\EditController::class,
    "/data/add"                 => App\Controllers\GET\Data\AddController::class,
    "/folder/:target"           => App\Controllers\GET\Viewer\FolderController::class,
    "/viewer/md/:target"        => App\Controllers\GET\Viewer\MDController::class,
    "/viewer/media/:target"     => App\Controllers\GET\Viewer\MediaController::class,
    "/editor/doc/:target"       => App\Controllers\GET\Editor\DocController::class,
    "/editor/json/:target"      => App\Controllers\GET\Editor\JSONController::class,
    // * 圖片資料
    "/storage/image/:filename"  => App\Controllers\GET\StorageImageController::class,
    "/storage/demo/:filename"   => App\Controllers\GET\StorageDemoImageController::class,
];
