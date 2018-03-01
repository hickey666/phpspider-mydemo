<?php
require_once __DIR__ . '/../autoloader.php';
use phpspider\core\phpspider;
use phpspider\core\requests;
use phpspider\core\db;
use phpspider\core\selector;

/* Do NOT delete this comment */
/* 不要删除这段注释 */

$configs = [
    'name' => 'sozai1',
    'tasknum' => 1,
    'log_show' => false,
    'max_try' => 5,
    'domains' => [
        'www.sozai-page.com',
    ],
    'scan_urls' => [
        'http://www.sozai-page.com/',
    ],
    'content_url_regexes' => array(
        'http://www.sozai-page.com/.+',
    ),
    // 'export' => array(
    //     'type' => 'db',
    //     'table' => 'photy_test',
    // ),
    // 'db_config' => array(
    //     'host'  => '127.0.0.1',
    //     'port'  => 3306,
    //     'user'  => 'root',
    //     'pass'  => 'root',
    //     'name'  => 'phpspider',
    // ),
    'fields' => [
        [
            'name' => 'img',
            'selector' => "//div[contains(@id,'cont')]/table/tr[2]/td[2]/table/tr/td/table/tr/td/table/tr/td/div/a/img",
            'repeated' => true,
        ],
    ],
];

// var_dump($configs);exit;
$spider = new phpspider($configs);


$spider->on_scan_page = function ($page, $content, $phpspider)
{
    // var_dump($content);exit;
    $selector = "//div[contains(@id,'cont')]/table/tr[2]/td[1]/table/tr[8]/td/table/tr/td/a/@href";
    $urls = selector::select($content, $selector);
    // var_dump($urls);exit;
    foreach ($urls as $val){
        if (strpos($val, '02_sozai') !== false){
            $url = 'http://www.sozai-page.com/' . $val;
            $phpspider->add_url($url);
        }
    }
    return false;
};


$spider->on_extract_field = function($fieldname, $data, $page)
{
    if ($fieldname == 'img' && $data)
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
        db::set_connect('sozai1', $config);
        // 数据库链接
        db::init_mysql();

        db::insert_batch("sozai", $data);
    }

    return $data;
};

$spider->start();