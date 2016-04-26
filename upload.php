<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 16/4/24
 * Time: 13:47
 */

include_once 'common.php';
include_once 'ResizeImage.class.php';

/**
 * 构建上传文件信息数组
 */
function getFiles() {
    $i = 0;
    $files = [];
    foreach ($_FILES as $file) {
        foreach ($file['name'] as $key => $value) {
            $files[$i]['name'] = $file['name'][$key];
            $files[$i]['type'] = $file['type'][$key];
            $files[$i]['tmp_name'] = $file['tmp_name'][$key];
            $files[$i]['error'] = $file['error'][$key];
            $files[$i]['size'] = $file['size'][$key];
            $i++;
        }
    }
    return $files;
}

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
    $fileName = md5(uniqid(microtime(true), true)) . '.png';
    // 门派分类
    $categoryName = $_POST['category'];

    // 如果没有上传成功则退出
    if ($fileInfo['error'] != UPLOAD_ERR_OK) {
        $error_message = '';
        switch ($fileInfo['error']) {
            case 1:
                $error_message = '上传超过了php配置文件中upload_max_filesize选项的值';
                break;
            case 2:
                $error_message = '超过了html表单MAX_FILE_SIZE大小限制';
                break;
            case 3:
                $error_message = '文件部分被上传';
                break;
            case 4:
                $error_message = '没有选择上传文件';
                break;
            case 6:
                $error_message = '没有找到临时目录';
                break;
            case 7:
            case 8:
                $error_message = '系统错误';
                break;
        }
        $result['message'] = $fileName . $error_message;
        return $result;
    }

    // 检测是否是图片
    if (!getimagesize($fileInfo['tmp_name'])) {
        $result['message'] = $fileName . '不是真实图片';
        return $result;
    }

    // 限制文件尺寸
    if ($fileInfo['size'] >= $maxSize) {
        $result['message'] = $fileName . '上传文件不能超过 2M';
        return $result;
    }

    // 判断上传方式
    if (!is_uploaded_file($fileInfo['tmp_name'])) {
        $result['message'] = $fileName . '不是通过HTTP POST方式上传的';
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

    // 限制文件类型
    if (!in_array($extension, $allowExtensionNames)) {
        $result['message'] = $fileName . '文件类型不允许上传';
        return $result;
    }

    // 转换文件类型
    if ($extension != "png") {
        try {
            $obj = new ReSizeImage();
            $obj->setSourceFile($fileInfo['tmp_name']);
            $obj->setDstFile($destination);
            $obj->setWidth(750);
            $obj->setHeight(1334);
            $obj->draw();
        } catch (Exception $ex) {
            $result['message'] = '转换图片格式出现异常 ->' . $ex;
            return $result;
        }
    } else {
        // 移动临时文件到指定目录
        if (!@move_uploaded_file($fileInfo['tmp_name'], $destination)) {
            $result['message'] = $fileName . '移动到' . $destination . '失败';
            return $result;
        }
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

// 检查权限
checkLogin();

// 上传文件
// 获取所有文件的信息数组
$files = getFiles();

// 取出单个文件的信息数组,上传文件
foreach ($files as $fileInfo) {
    $result = uploadFile($fileInfo, $pdo);
    print_r($result);
}
