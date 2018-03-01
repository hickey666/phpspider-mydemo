<?php
require_once __DIR__ . '/../autoloader.php';
use phpspider\core\phpspider;
use phpspider\core\requests;
use phpspider\core\db;

/* Do NOT delete this comment */
/* 不要删除这段注释 */

$configs = [
    'name' => 'designerspics',
    'tasknum' => 1,
    'log_show' => false,
    'max_try' => 5,
    'domains' => [
        'www.designerspics.com',
    ],
    'scan_urls' => [
        'http://www.designerspics.com',
    ],
    // 'list' => [
    //     'http://www.designerspics.com/page/\d+/',
    // ],
    'content_url_regexes' => array(
        'http://www.designerspics.com/page/\d+/',
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
            'selector' => "//div[contains(@class,'photos')]/a/img",
            'repeated' => true,
        ],
    ],
];

// var_dump($configs);exit;
$spider = new phpspider($configs);


$spider->on_scan_page = function ($page, $content, $phpspider)
{
    // var_dump($content);exit;
    for ($i = 1; $i <= 24; $i++){
        $url = "http://www.designerspics.com/page/{$i}/";
        $urls[] = $url;
        $phpspider->add_url($url);
    }
    // var_dump($urls);
    return false;
    // var_dump($phpspider);exit;
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
        db::set_connect('designerspics', $config);
        // 数据库链接
        db::init_mysql();

        db::insert_batch("designerspics", $data);
    }

    return $data;
};

$spider->start();