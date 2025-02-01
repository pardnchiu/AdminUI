<?php

namespace App\Controllers\GET\Data;

use App\Controllers\Controller;
use App\Models\Async;
use App\Models\SQL;

class ListController extends Controller
{
    private string $view = "Data/List";
    private int $page = 1;
    private int $page_row = 10;
    private int $page_max = 0;
    private string $order_by = "sn";
    private string $order_direct = "DESC";
    private array $filter = [];

    public function __construct($params)
    {
        parent::__construct($params);

        $this->check_auth();

        $this->page = (int) max((isset($_GET["page"]) ? trim($_GET["page"]) : 1) - 1, 0);
        $this->page_row = (int) max((isset($_GET["row"]) ? trim($_GET["row"]) : 10), 50);
        $this->order_by = (string) (isset($_GET["order"]) ? trim($_GET["order"]) : "sn");
        $this->order_direct = (string) (isset($_GET["direct"]) ? trim($_GET["direct"]) : "DESC");

        $filter = (string) (isset($_GET["filter"]) ? trim($_GET["filter"]) : "");

        if ($filter != "") {
            $this->filter = get_json_from_save_base64($filter);
        };
    }

    public function init()
    {
        try {
            $tasks = [
                "data_list" => [
                    "method" => fn() => $this->select_article()
                ]
            ];
            Async::run($tasks)
                ->then(fn($result) => $this->render($result))
                ->catch(fn($err) => throw $err);
        } catch (\Exception $err) {
            PrintError($err->getMessage());
        };
    }

    private function select_article()
    {
        $result = SQL::table("data")->where("dismiss", "0");

        if (count($this->filter) > 0) {
            foreach ($this->filter as $value) {
                $result = $result->where($value["key"], $value["compare"], $value["value"]);
            };
        };

        $result = $result->order_by($this->order_by, $this->order_direct)
            ->limit($this->page_row)
            ->offset($this->page * $this->page_row)
            ->total()
            ->get();

        if (empty($result)) {
            return [];
        };

        $total = (int) $result[0]["total"];
        $this->page_max = ceil($total / $this->page_row);

        foreach ($result as $e) {
            $ary[] = [
                $e["sn"],
                $e["uid"],
                $e["single"],
                $e["mutiple"],
                $e["eng_num"],
                $e["number"],
                $e["email"],
                $e["password"],
                $e["date"] ? $this->date_format($e["date"]) : null,
                $e["radio"],
                $e["checkbox"],
                $e["select"],
                $e["image"],
                $e["upload"] ? $this->date_format($e["upload"]) : null,
                $e["updated"] ? $this->date_format($e["updated"])  : null,
            ];
        };

        return $ary;
    }

    private function date_format($date)
    {
        return (new \DateTime($date, new \DateTimeZone("UTC")))
            ->setTimezone(new \DateTimeZone('Asia/Taipei'))
            ->format("Y-m-d H:i:s");
    }

    private function render($data = [])
    {
        extract([
            ...$data,
            "path" => "/datas",
            "page" => max(1, min($this->page, $this->page_max)),
            "page_max" => $this->page_max,
            "filter" => $this->filter,
            "compare" => [
                "等於" => "=",
                "不等於" => "!=",
                "大於" => ">",
                "大於等於" => ">=",
                "小於" => "<",
                "小於等於" => "<=",
                "包含" => "LIKE"
            ],
            "table_head" => [
                "sn" => "編號",
                "uid" => "uid",
                "single" => "單行輸入",
                "mutiple" => "多行輸入",
                "eng_num" => "英文數字底線",
                "number" => "數字",
                "email" => "Email",
                "password" => "密碼",
                "date" => "時間",
                "radio" => "單選",
                "checkbox" => "多選",
                "select" => "選項",
                "image" => "圖片",
                "upload" => "發布日期",
                "updated" => "更新日期"
            ]
        ]);

        ob_start();

        include get_view($this->view);

        echo ob_get_clean();
    }
}
