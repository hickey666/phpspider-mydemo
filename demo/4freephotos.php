<?php
require_once __DIR__ . '/../autoloader.php';
use phpspider\core\phpspider;
use phpspider\core\requests;
use phpspider\core\db;
use phpspider\core\selector;

/* Do NOT delete this comment */
/* 不要删除这段注释 */

$configs = [
    'name' => '4freephotos',
    'tasknum' => 1,
    'log_show' => false,
    'max_try' => 5,
    'domains' => [
        'www.4freephotos.com',
    ],
    'scan_urls' => [
        'http://www.4freephotos.com/photos.php',
    ],
    'list_url_regexes' => [
        'http://www.4freephotos.com/photos.php\?\&page=\d+\&order=latest'
    ],
    'content_url_regexes' => array(
        'http://www.4freephotos.com/[^\s]*.html'
    ),
    'export' => array(
        'type' => 'db',
        'table' => '4freephotos',
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
            'selector' => "//div[contains(@class,'showimgthumb')]//img",
            'required' => true,
        ],
        // 类型
        [
            'name' => 'type',
            'selector' => "//div[contains(@class,'contentBox')]/div[2]/div[2]/p",
            'required' => true,
        ],
    ],
];

// var_dump($configs);exit;
$spider = new phpspider($configs);


$spider->on_scan_page = function ($page, $content, $phpspider)
{
    // var_dump($content);exit;
    for ($i = 1; $i < 346; $i++){
        $url = "http://www.4freephotos.com/photos.php?&page={$i}&order=latest";
        $phpspider->add_url($url);
    }
    return false;
};


$spider->on_list_page = function ($page, $content, $phpspider)
{

    $selector = "//div[contains(@class,'search-thumb')]//a/@href";
    $urls = selector::select($page['raw'], $selector);
    foreach ($urls as $val){
        $url = "http://www.4freephotos.com/" . $val;
        $phpspider->add_url($url);
    }
    return false;
    // var_dump($phpspider);exit;
};

$spider->on_extract_field = function($fieldname, $data, $page)
{
    // var_dump($data);exit;

    if ($fieldname == 'img')
    {
        $data = "http://www.4freephotos.com" . $data;
    }
    // var_dump($data);exit;

    return $data;
};

$spider->start();