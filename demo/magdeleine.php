<?php
require_once __DIR__ . '/../autoloader.php';
use phpspider\core\phpspider;
use phpspider\core\requests;
use phpspider\core\db;

/* Do NOT delete this comment */
/* 不要删除这段注释 */

$configs = [
    'name' => 'magdeleine',
    'tasknum' => 1,
    'log_show' => false,
    'max_try' => 5,
    'domains' => [
        'magdeleine.co',
    ],
    'scan_urls' => [
        'https://magdeleine.co/license/attribution-required/',
    ],

    'content_url_regexes' => array(
        'https://magdeleine.co/license/attribution-required/page/\d+/',
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
            'selector' => "//img[contains(@class,'attachment-photo-thumb')]",
            'repeated' => true,
        ],
    ],
];

// var_dump($configs);exit;
$spider = new phpspider($configs);


$spider->on_scan_page = function ($page, $content, $phpspider)
{
    // var_dump($content);exit;
    for ($i = 1; $i < 25; $i++){
        $url = "https://magdeleine.co/license/attribution-required/page/{$i}/";
        $phpspider->add_url($url);
    }
    // var_dump($phpspider);exit;
};


$spider->on_extract_field = function($fieldname, $data, $page)
{

    if ($fieldname == 'img')
    {
        // var_dump($data);exit;
        foreach ($data as $k => $v){
            $data[$k] = [
                'img' => "https://photy.org" . $v,
                'type' => 'attribution-required',
            ];
        }
        // var_dump($data);exit;
        $config = [
            'host'  => '127.0.0.1',
            'port'  => 3306,
            'user'  => 'root',
            'pass'  => 'root',
            'name'  => 'phpspider',
        ];
        // 数据库配置
        db::set_connect('default', $config);
        // 数据库链接
        db::init_mysql();

        db::insert_batch("magdeleine", $data);
    }

    return $data;
};

$spider->start();