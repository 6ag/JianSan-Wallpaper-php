<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 16/4/25
 * Time: 17:19
 */

include_once 'common.php';

/**
 * 上传文件
 * @param $fileInfo 单个文件信息数组
 * @param $pdo      数据库对象
 * @return mixed    返回结果数组
 */
function uploadFile($fileInfo, $pdo) {
    // 上传文件大小2M
    $maxSize = 2097152;
    // 支持的扩展名
    $allowExtensionNames = ['jpeg', 'jpg', 'png'];
    // 图片扩展名
    $extension = pathinfo($fileInfo['name'], PATHINFO_EXTENSION);
    // 唯一图片文件名
    $fileName = md5(uniqid(microtime(true), true)) . '.' . $extension;
    // 门派分类
    $categoryName = $fileInfo['category'];

    // 检测是否是图片
    if (!getimagesize($fileInfo['path'])) {
        $result['message'] = $fileName . '不是真实图片';
        return $result;
    }

    // 限制文件类型
    if (!in_array($extension, $allowExtensionNames)) {
        $result['message'] = $fileName . '文件类型不允许上传';
        return $result;
    }

    // 目录是否存在 不存在则创建
    $path = 'resource/' . $categoryName . '/';
    if (!file_exists($path)) {
        if (!(mkdir($path, 0777, true) && chmod($path, 0777))) {
            $result['message'] = $path . '不存在,并且无权限创建';
            return $result;
        }
    }

    // 存放文件路径
    $destination = $path . $fileName;

    // 移动临时文件到指定目录
    if (!@copy($fileInfo['path'], $destination)) {
        $result['message'] = $fileName . '复制到' . $destination . '失败';
        return $result;
    }

    // 插入壁纸路径到数据库sql
    $sql = "INSERT INTO jf_wallpaper (category, path) VALUES (\"$categoryName\",\"$destination\")";

    // 保存壁纸信息到数据库
    if (!$pdo->query($sql)) {
        $result['message'] = '存入数据库失败';
        return $result;
    }

    // 返回成功结果
    $result['message'] = '上传成功';
    $result['destination'] = $destination;
    return $result;
}

// 存储所有图片信息数组的数组
$allFileInfo = [];

/**
 * 获取文件信息
 * @param $directory
 * @param string $caregory
 */
function get_file_infos($directory, $caregory='') {
    $mydir = dir($directory);
    $fileInfo = [];
    while($file = $mydir->read()) {
        if((is_dir("$directory/$file")) AND ($file != ".") AND ($file != "..") AND ($file != '.DS_Store')) {
            // 递归遍历目录
            get_file_infos("$directory/$file", $file);
        } else if (($file != '.') AND ($file != '..') AND ($file != '.DS_Store')) {
            $path = $directory . '/' .$file;
            // 图片路径和图片分类
            $fileInfo['path'] = $path;
            $fileInfo['name'] = $file;
            $fileInfo['category'] = $caregory;

            global $allFileInfo;
            array_push($allFileInfo, $fileInfo);
        }
    }
    $mydir->close();
}

// 遍历指定路径下的所有文件并拼装文件信息数组
get_file_infos($config['initdataPath']);

foreach ($allFileInfo as $fileInfo) {
    // 上传文件并保存到数据库
    $result = uploadFile($fileInfo, $pdo);
    print_r($result);
}
