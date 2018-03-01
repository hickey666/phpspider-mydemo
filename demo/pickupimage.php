<?php
require_once __DIR__ . '/../autoloader.php';
use phpspider\core\phpspider;
use phpspider\core\requests;
use phpspider\core\db;
use phpspider\core\selector;

/* Do NOT delete this comment */
/* 不要删除这段注释 */

$configs = [
    'name' => 'pickupimage',
    'tasknum' => 1,
    'log_show' => false,
    'max_try' => 5,
    'domains' => [
        'pickupimage.com',
    ],
    'scan_urls' => [
        'http://pickupimage.com/cn/',
    ],
    'list_url_regexes' => [
        'http://pickupimage.com/cn/search.cfm\?kw=\&id=0\&sortby=\w+\&page=\d+',
        'http://pickupimage.com/cn/free-cliparts/index.cfm\?kw=\&id=0\&sortby=new\&page=\d+'
    ],
    'content_url_regexes' => array(
        'http://pickupimage.com/cn/view.cfm\?id=\d+'
    ),
    'export' => array(
        'type' => 'db',
        'table' => 'pickupimage',
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
            'selector' => "//img[contains(@class,'thumb_image')]",
            'required' => true,
        ],
        // 类型
        [
            'name' => 'type',
            'selector' => "//div[contains(@class,'section_head')]/h5",
            'required' => true,
        ],
    ],
];

// var_dump($configs);exit;
$spider = new phpspider($configs);

$sortbys = [
    'favorites' => 31,
    'new' => 814,
    'download' => 915,
    'views' => 694,
    'diff' => 104,
];

$spider->on_scan_page = function ($page, $content, $phpspider) use ($sortbys)
{
    foreach ($sortbys as $sortby => $page){
        if ($sortby != "diff"){
            for ($i = 1; $i <= $page; $i++){
                $url = "http://pickupimage.com/cn/search.cfm?kw=&id=0&sortby={$sortby}&page={$i}";
                $phpspider->add_url($url);
            }
        }else{
            for ($i = 1; $i <= $page; $i++){
                $url = "http://pickupimage.com/cn/free-cliparts/index.cfm?kw=&id=0&sortby=new&page={$i}";
                $phpspider->add_url($url);
            }
        }
    }

    return false;
};


$spider->on_list_page = function ($page, $content, $phpspider)
{
    $selector = "//div[contains(@class,'gallery-item')]/a/@href";
    $urls = selector::select($page['raw'], $selector);
    foreach ($urls as $val){
        $url = "http://pickupimage.com" . $val;
        if (strpos($page['url'], 'free-cliparts')){
            $phpspider->add_url($val);
        }else{
            $phpspider->add_url($url);
        }
    }
    return false;
};

$spider->on_extract_field = function($fieldname, $data, $page)
{
    return $data;
};

$spider->start();