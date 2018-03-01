<?php
require_once __DIR__ . '/../autoloader.php';
use phpspider\core\phpspider;
use phpspider\core\requests;
use phpspider\core\db;
use phpspider\core\selector;

/* Do NOT delete this comment */
/* 不要删除这段注释 */

$configs = [
    'name' => 'stokpic',
    'tasknum' => 1,
    'log_show' => false,
    'max_try' => 5,
    'domains' => [
        'stokpic.com',
    ],
    'scan_urls' => [
        'http://stokpic.com',
    ],
    'content_url_regexes' => array(
        'http://stokpic.com/categories/[^\s]*/page/\d+/'
    ),
    // 'export' => array(
    //     'type' => 'db',
    //     'table' => 'stokpic',
    // ),
    // 'db_config' => array(
    //     'host'  => '127.0.0.1',
    //     'port'  => 3306,
    //     'user'  => 'root',
    //     'pass'  => '123456',
    //     'name'  => 'phpspider',
    // ),
    'fields' => [
        // 图片地址
        [
            'name' => 'img',
            'selector' => "//span[contains(@class,'et_portfolio_image')]/img",
            'repeated' => true,
        ],
    ],
];

// var_dump($configs);exit;
$spider = new phpspider($configs);

$cates = [
    "abstract" => 7,
    "animals" => 3,
    "architecture" => 9,
    "background" => 16,
    "black-white" => 3,
    "fashion" => 6,
    "food-drink" =>6,
    "landscape" => 23,
    "lifestyle" => 19,
    "live-events" => 3,
    "nature" => 11,
    "objects" => 17,
    "people" => 20,
    "sports-fitness" => 5,
    "transport" => 6,
    "technology" => 6,
];

$spider->on_scan_page = function ($page, $content, $phpspider) use ($cates)
{
    // for ($i = 1; $i < 3; $i++){
    //     $url = "http://foter.com/nature/{$i}";
    //     $phpspider->add_url($url);
    // }
    // var_dump($content);exit;
    foreach ($cates as $cate => $page){
        for ($i = 1; $i <= $page; $i++){
            $url = "http://stokpic.com/categories/{$cate}/page/{$i}/";
            $urls[] = $url;
            $phpspider->add_url($url);
        }
    }
    // var_dump($urls);exit;
    return false;
};


$spider->on_extract_field = function($fieldname, $data, $page)
{
    // var_dump($data);exit;
    if ($fieldname == 'img')
    {
        // var_dump($data);exit;
        foreach ($data as $k => $v){
            $data[$k] = [
                'img' => $v,
            ];
        }
        // var_dump($data);exit;
        $config = [
            'host'  => '127.0.0.1',
            'port'  => 3306,
            'user'  => 'root',
            'pass'  => '123456',
            'name'  => 'phpspider',
        ];
        // 数据库配置
        db::set_connect('stokpic', $config);
        // 数据库链接
        db::init_mysql();

        db::insert_batch("stokpic", $data);
    }
    return $data;
};

$spider->start();