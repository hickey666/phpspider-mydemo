<?php
require_once __DIR__ . '/../autoloader.php';
use phpspider\core\phpspider;
use phpspider\core\requests;
use phpspider\core\db;
use phpspider\core\selector;

/* Do NOT delete this comment */
/* 不要删除这段注释 */

$configs = [
    'name' => 'lagou',
    'tasknum' => 1,
    'log_show' => true,
    'domains' => [
        'easy.lagou.com'
    ],
    'scan_urls' => [
        'https://easy.lagou.com'
    ],
    'content_url_regexes' => [
        'https://easy.lagou.com/can/new/list.json'
    ],
    'fields' => [
        [
            'name' => 'content',
            'selector_type' => 'regex',
            'selector' => '#{.+}#',
        ]
    ],
];