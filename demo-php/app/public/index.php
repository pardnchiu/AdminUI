<?php
$ROOT = $_SERVER["DOCUMENT_ROOT"];

function PATH($path) {
    global $ROOT;
    return $ROOT . $path;
};

function GET_VIEW($path) {
    return  PATH("/resources/Views/" . $path . ".php");
};

require_once PATH("/src/Init.php");
