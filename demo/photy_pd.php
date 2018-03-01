<?php
require_once __DIR__ . '/../autoloader.php';
use phpspider\core\phpspider;
use phpspider\core\requests;
use phpspider\core\db;

/* Do NOT delete this comment */
/* 不要删除这段注释 */

$configs = [
    'name' => 'photy',
    'tasknum' => 1,
    'log_show' => false,
    'domains' => [
        'photy.org',
    ],
    'scan_urls' => [
        'https://photy.org/en/free-photos/',
    ],

    'content_url_regexes' => array(
        'https://photy.org/en/free-photos/\?sort=date\&formatRadios=all\&nopage=90\&license=1\&page=\d+',
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
            'selector' => "//img[contains(@class,'photo-thumbnail')]",
            'repeated' => true,
        ],
    ],
];

// var_dump($configs);exit;
$spider = new phpspider($configs);


$spider->on_scan_page = function ($page, $content, $phpspider)
{
    // var_dump($content);exit;
    for ($i = 1; $i < 60; $i++){
        $url = "https://photy.org/en/free-photos/?sort=date&formatRadios=all&nopage=90&license=1&page={$i}";
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
                'type' => 'pd',
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

        db::insert_batch("photy_test", $data);
    }

    return $data;
};

$spider->start();