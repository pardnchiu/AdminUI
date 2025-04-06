<?php

namespace App\Controllers\GET\Viewer;

use App\Controllers\Controller;

class FolderController extends Controller
{
    private string $view = "Viewer/Folder";

    public function __construct($params)
    {
        parent::__construct($params);

        $this->check_auth();
    }

    public function init()
    {
        $this->render();
    }

    private function render()
    {
        $target = $this->params["target"];

        if (!preg_match("/\/$/", $target)) {
            $target = $target . "/";
        };
        $folder_path = "/" . $target;
        $dir = get_path($folder_path);
        // $items = array_diff(scandir($dir), array(".", ".."));

        // 獲取目錄列表
        $allItems = scandir($dir);
        
        PrintDebug($target);
        // 分離特殊目錄和一般檔案
        $specialDirs = $target == "storage/" ? [] : array_filter($allItems, fn($item) => $item === "..");
        $normalItems = array_filter($allItems, function($item) {
            // 排除 . 和 .. ，以及其他隱藏檔案
            return !($item === "." || $item === "..") && !preg_match('/^\./', $item);
        });
        
        // 合併特殊目錄和一般檔案
        $items = array_merge($specialDirs, $normalItems);

        $files = [];
        $folders = [];

        if (preg_match("/^storage/", $target)) {
            foreach ($items as $item) {
                if (is_dir("$dir/$item")) {
                    $folders[] = [
                        "href" => "/folder" . $folder_path . $item,
                        "folder_name" => $item
                    ];
                } else {
                    $is_media = is_file_media($item);
                    $is_image = is_file_image($item);
                    $src = [
                        "document" => "https://cdn.jsdelivr.net/npm/@pardnchiu/adminui@latest/dist/image/document.svg",
                        "media" => "https://cdn.jsdelivr.net/npm/@pardnchiu/adminui@latest/dist/image/video.svg",
                        "image" => $folder_path . $item
                    ][get_file_type($item)];

                    switch (true) {
                        case (get_file_extension($item) === "json"):
                            $href = "/editor/json" . $folder_path . $item;
                            break;
                        case ($is_image):
                        case ($is_media):
                            $href = "/viewer/media" . $folder_path . $item;
                            break;
                        default:
                            $href = "/editor/doc" . $folder_path . $item;
                            break;
                    };

                    $files[] = [
                        "href" => $href,
                        "src" => $src,
                        "filename" => $item
                    ];
                };
            };
        };

        extract([
            "path" => "/folder/" . $target,
            "folder_path" => $folder_path,
            "folders" => $folders,
            "files" => $files
        ]);

        ob_start();

        include get_view($this->view);

        echo ob_get_clean();
    }
}
