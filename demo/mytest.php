<?php
require_once __DIR__ . '/../autoloader.php';
// use phpspider\core\phpspider;
use phpspider\core\requests;
use phpspider\core\selector;
use phpspider\core\db;


$url = 'http://www.sozai-page.com/02_sozai/a/a01/a01_231/a01_231.html';
// $url = "http://pickupimage.com/cn/view.cfm?id=2317877#.WpY_SY30xFs";
$html = requests::get($url);

// 抽取类别
// $selector = "//li[contains(@class,'menu-item-160')]/ul/li/a/@href";
// $type = selector::select($html, $selector);
// var_dump($type);exit;
// $selector = "//div[contains(@class,'section_head')]/h5";
// $type = selector::select($html, $selector);
// var_dump($type);exit;
// 抽取图片路径
// $selector = "//div[contains(@id,'cont')]/table/tr[2]/td[2]/table/tr/td/table/tr/td/table/tr/td/div/a/img";
// $img = selector::select($html, $selector);
// var_dump($img);exit;
// $selector = "//div[contains(@id,'cont')]/table/tr[2]/td[2]/table/tr/td/table/tr/td/a/img";
// $img = selector::select($html, $selector);
// var_dump($img);exit;
// $selector = "//div[contains(@id,'cont')]/table/tr[2]/td[1]/table/tr[8]/td/table/tr/td/a/@href";
// $urls = selector::select($html, $selector);
// var_dump($urls);exit;
$img = array_map(function($val){
    return "https://photy.org" . $val;
}, $img);
$data = [];

foreach ($img as $k => $v){
    $data[$k] = [
        'img' => $v,
        'type' => 'ccsa',
    ];
}

$config = [
    'host'  => '127.0.0.1',
    'port'  => 3306,
    'user'  => 'root',
    'pass'  => 'root',
    'name'  => 'phpspider',
];

// var_dump($data);exit;

// 数据库配置
db::set_connect('default', $config);
// 数据库链接
db::init_mysql();

db::insert_batch("photy_test", $data);