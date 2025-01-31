<?php

namespace GET;

use Controllers\Controller;
use Models\Async;
use Models\SQL;

class ArticleListController extends Controller
{
    private string $view = "ArticleList";
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
            $this->filter = GET_FRMO_BASE64($filter);
        };
    }

    public function init()
    {
        try {
            $tasks = [
                "article_list" => [
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
        $result = SQL::table("article")->where("dismiss", "0");

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
                $e["slug"],
                $e["title"],
                $e["subtitle"],
                $e["topic"],
                $e["hashtag"],
                $e["content"],
                $e["watch"] ? $e["watch"] : "0",
                $e["comment"] ? $e["comment"] : "0",
                $e["upload"] ? $this->date_format($e["upload"]) : "-",
                $e["updated"] ? $this->date_format($e["updated"])  : "-",
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
            "path" => "/articles",
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
                "slug" => "自訂ID",
                "title" => "標題",
                "subtitle" => "副標題",
                "topic" => "分類",
                "tag" => "標籤",
                "content" => "內容",
                "watch" => "觀看數",
                "comment" => "留言數",
                "upload" => "發布日期",
                "updated" => "更新日期"
            ]
        ]);

        ob_start();

        include GET_VIEW($this->view);

        echo ob_get_clean();
    }
}
