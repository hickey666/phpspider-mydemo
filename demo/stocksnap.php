<?php
require_once __DIR__ . '/../autoloader.php';
use phpspider\core\log;
use phpspider\core\requests;
use phpspider\core\db;

$sorts = [
    'date',
    'trending',
    'views',
    'downloads',
    'favorites'
];
$imgs = [];
foreach ($sorts as  $sort){
    for ($i = 1; $i <= 651; $i++){
        $url = "https://stocksnap.io/api/load-photos/{$sort}/desc/{$i}";
        $res = requests::get($url);
        if (!empty($res)){
            $res = json_decode($res);
            foreach ($res as $key => $val){
                if ($key == 'results'){
                    foreach ($val as $item){
                        $imgs[]['img'] = "https://cdn.stocksnap.io/img-thumbs/280h/" . $item->img_id;
                    }
                }
            }
        }
    }
}
// var_dump($imgs);
$config = [
    'host'  => '127.0.0.1',
    'port'  => 3306,
    'user'  => 'root',
    'pass'  => '123456',
    'name'  => 'phpspider',
];
// 数据库配置
db::set_connect('default', $config);
// 数据库链接
db::init_mysql();

db::insert_batch("stocksnap", $imgs);

