<?php
require_once __DIR__ . '/../autoloader.php';
use phpspider\core\phpspider;
use phpspider\core\requests;
use phpspider\core\db;
use phpspider\core\selector;

/* Do NOT delete this comment */
/* 不要删除这段注释 */

$configs = [
    'name' => 'foter',
    'tasknum' => 1,
    'log_show' => false,
    'max_try' => 5,
    'domains' => [
        'foter.com',
    ],
    'scan_urls' => [
        'http://foter.com/business/',
    ],
    'list_url_regexes' => [
        'http://foter.com/[^\s]*/\d+'
    ],
    'content_url_regexes' => array(
        'http://foter.com/photo/[^\s]*'
    ),
    'export' => array(
        'type' => 'db',
        'table' => 'foter',
    ),
    'db_config' => array(
        'host'  => '127.0.0.1',
        'port'  => 3306,
        'user'  => 'root',
        'pass'  => '123456',
        'name'  => 'phpspider',
    ),
    'fields' => [
        // 图片地址
        [
            'name' => 'img',
            'selector' => "//img[contains(@class,'bigPhoto__img')]",
            'required' => true,
        ],
        // 类型
        [
            'name' => 'type',
            'selector' => "//span[contains(@class,'text--small')]/a",
            'required' => true,
        ],
    ],
];

// var_dump($configs);exit;
$spider = new phpspider($configs);

$cates = [
    'business' => 21,
    'animals' => 21,
    'nature' => 40,
    'abstract' => 12,
    'art' => 30,
    'buildings' => 33,
    'celebrities' => 1,
    'education' => 7,
    'fashion' =>32,
    'food' => 106,
    'holidays' => 8,
    'interiors' => 3,
    'nature' => 491,
    'outdoor' => 35,
    'people' => 54,
    'religion' => 15,
    'sports' => 11,
    'technology' => 27,
    'vintage' => 33,
];

$spider->on_scan_page = function ($page, $content, $phpspider) use ($cates)
{
    // for ($i = 1; $i < 3; $i++){
    //     $url = "http://foter.com/nature/{$i}";
    //     $phpspider->add_url($url);
    // }
    // var_dump($content);exit;
    foreach ($cates as $cate => $page){
        for ($i = 1; $i < $page; $i++){
            $url = "http://foter.com/{$cate}/{$i}";
            $phpspider->add_url($url);
        }
    }
    return false;
};


$spider->on_list_page = function ($page, $content, $phpspider)
{
    $selector = "//div[contains(@class,'photoGrid__item')]/a/@href";
    $urls = selector::select($content, $selector);
    foreach ($urls as $val){
        $url = "http://foter.com" . $val;
        $phpspider->add_url($url);
    }
    return false;
};

$spider->on_extract_field = function($fieldname, $data, $page)
{
    return $data;
};

$spider->start();