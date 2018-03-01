<?php
require_once __DIR__ . '/../autoloader.php';
// use phpspider\core\phpspider;
use phpspider\core\requests;
use phpspider\core\selector;
use phpspider\core\db;

/* Do NOT delete this comment */
/* 不要删除这段注释 */

// 模拟登录
$cookies = "pipBookMarkTips=true; user_trace_token=20180227101616-308fd7ee-1b64-11e8-937e-525400f775ce; PRE_UTM=m_cf_cpc_baidu_pc; PRE_HOST=www.baidu.com; PRE_SITE=https%3A%2F%2Fwww.baidu.com%2Fs%3Fwd%3D%25E6%258B%2589%25E5%258B%25BE%25E7%25BD%2591%26rsv_spt%3D1%26rsv_iqid%3D0x98ad1cd700030b02%26issp%3D1%26f%3D8%26rsv_bp%3D1%26rsv_idx%3D2%26ie%3Dutf-8%26rqlang%3Dcn%26tn%3Dbaiduhome_pg%26rsv_enter%3D0%26oq%3Dphp%252520%2525E7%252588%2525AC%2525E5%25258F%252596%2525E6%25258B%252589%2525E9%252592%2525A9%2525E6%252595%2525B0%2525E6%25258D%2525AE%26rsv_t%3D333dPZXYBM1byXc1Lc9Rp%252FUkrB%252F8T%252BYeViP5muR6nczjveCY558%252BVR8X%252B%252FZEiC2CiNCA%26inputT%3D2154660%26rsv_pq%3Dac9aaef60000e4cc%26rsv_sug3%3D154%26rsv_sug1%3D134%26rsv_sug7%3D100%26bs%3Dphp%2520%25E7%2588%25AC%25E5%258F%2596%25E6%258B%2589%25E9%2592%25A9%25E6%2595%25B0%25E6%258D%25AE; PRE_LAND=https%3A%2F%2Fpassport.lagou.com%2Flp%2Fhtml%2Fcommon.html%3Futm_source%3Dm_cf_cpc_baidu_pc%26m_kw%3Dbaidu_cpc_sh_e110f9_d2162e_%25E6%258B%2589%25E5%258B%25BE%25E7%25BD%2591; LGUID=20180227101616-308fe2d3-1b64-11e8-937e-525400f775ce; gate_login_token=d6458e85805e5095330c12dec30c6d6e44b780d92d44ccb9; index_location_city=%E4%B8%8A%E6%B5%B7; JSESSIONID=ABAAABAACCIABGB1B03BD9B8DE4081F2064B336E335AD48; mds_login_authToken=\"SLn3IqBNQMk4ecx5bNMcpfQfTNSz7doy4xH26JRpCQYMdV8qMValgGSLQ2Az6wgSn8xJXaeWGxhVHRoD6AsRc8U3ir6RmnRJ6fumeFdvd8/FdjoQ365ElR8atxzf0tkh1V2Q1Ks/o28rLbnKHi15VYLLUvhr+LoL8zIy8HfW6w94rucJXOpldXhUiavxhcCELWDotJ+bmNVwmAvQCptcy5e7czUcjiQC32Lco44BMYXrQ+AIOfEccJKHpj0vJ+ngq/27aqj1hWq8tEPFFjdnxMSfKgAnjbIEAX3F9CIW8BSiMHYmPBt7FDDY0CCVFICHr2dp5gQVGvhfbqg7VzvNsw==\"; mds_u_n=Kevin; mds_u_ci=2519; mds_u_cn=%5Cu4e0a%5Cu6d77%5Cu6211%5Cu56fe%5Cu7f51%5Cu7edc%5Cu79d1%5Cu6280%5Cu6709%5Cu9650%5Cu516c%5Cu53f8; mds_u_s_cn=%5Cu97e9%5Cu521b%5Cu79d1%5Cu6280; _gat=1; sajssdk_2015_cross_new_user=1; _putrc=07AD574ACD847225; login=true; unick=dasiy; _ga=GA1.2.2104875332.1519697775; _gid=GA1.2.1415831108.1519697775; Hm_lvt_4233e74dff0ae5bd0a3d81c6ccf756e6=1519697776; Hm_lpvt_4233e74dff0ae5bd0a3d81c6ccf756e6=1519697886; X_HTTP_TOKEN=ba8efc1943de65ec4e98ff77480c8234; sensorsdata2015jssdkcross=%7B%22distinct_id%22%3A%22161d50d7368138-0c0f1640db16d8-35437c5c-2073600-161d50d73696da%22%2C%22%24device_id%22%3A%22161d50d7368138-0c0f1640db16d8-35437c5c-2073600-161d50d73696da%22%2C%22props%22%3A%7B%22%24latest_traffic_source_type%22%3A%22%E7%9B%B4%E6%8E%A5%E6%B5%81%E9%87%8F%22%2C%22%24latest_referrer%22%3A%22%22%2C%22%24latest_referrer_host%22%3A%22%22%2C%22%24latest_search_keyword%22%3A%22%E6%9C%AA%E5%8F%96%E5%88%B0%E5%80%BC_%E7%9B%B4%E6%8E%A5%E6%89%93%E5%BC%80%22%7D%7D; Hm_lvt_bfa5351db2249abae67476f1ec317000=1519697884,1519697993; Hm_lpvt_bfa5351db2249abae67476f1ec317000=1519698362; _ga=GA1.3.2104875332.1519697775; LGSID=20180227101616-308fdeb2-1b64-11e8-937e-525400f775ce; LGRID=20180227102602-8e62a505-1b65-11e8-9382-525400f775ce; gray=resume";
requests::set_cookies($cookies, 'easy.lagou.com');

// 接下来我们来访问一个需要登录后才能看到的页面
$url = "https://easy.lagou.com/can/new/list.json";
requests::set_referer("https://easy.lagou.com/can/new/index.htm?can=true&stage=NEW&needQueryAmount=true&pageNo=1");
$params = [
    'can' => "true",
    "stage" => "NEW",
    "needQueryAmount" => "false",
    "pageNo" => 1,
];
$html = requests::post($url, $params);
echo $html;     // 可以看到登录后的页面，非常棒👍
