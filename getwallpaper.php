<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 16/4/25
 * Time: 22:02
 */

include_once 'common.php';

/**
 * 根据分类查询数据
 * @param $category          分类
 * @param int $currentPage   当前页码
 * @param int $onePageCount  每页数量
 * @param $pdo               pdo单例
 * @return string            json数据
 */
function get_wallpaper($category, $currentPage, $onePageCount, $pdo) {
    // 计算分页
    $pre_count = ($currentPage - 1) * $onePageCount;
    $oneCount = $onePageCount;

    $sql = "SELECT * FROM jf_wallpaper WHERE category=\"$category\" ORDER BY ID DESC LIMIT $pre_count, $oneCount";
    $result = $pdo->getAll($sql);

    // 返回json数据
    $json['code'] = 1;
    $json['message'] = '成功';
    $json['data'] = $result;

    return json_encode($json);
}

// 处理请求参数
// 分类 / 当前页码
if (@!($category = $_GET['category']) || @!($currentPage = $_GET['currentPage'])) {
    $json['code'] = 0;
    $json['message'] = '必要参数缺失';
    $json['data'] = [];
    exit(json_encode($json));
}

// 单页数量
if (@!($onePageCount = $_GET['onePageCount'])) {
    $onePageCount = 10;
}

// 查询数据
$json = @get_wallpaper($category, $currentPage, $onePageCount, $pdo);
exit($json);