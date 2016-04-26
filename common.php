<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 16/4/25
 * Time: 11:56
 */

include_once 'MySQLDB.class.php';
include_once 'config.php';

header('context-type:text/html;charset=utf-8');

// 创建数据库对象
$pdo = MySQLDB::getInstance($config);

/**
 * 跳转界面方法
 * @param $url            指定url
 * @param string $message 提示信息
 * @param int $time       间隔时间
 */
function jumpToPage($url, $message = "正在跳转", $time = 2) {
    echo '<div style="height: 30%"></div>';
    echo "<center><h2>$message</h2></center>";
    echo "<meta http-equiv=\"refresh\" content=\"$time; url=$url\">";
}

/**
 * 判断是否登录 如果没有登录自动回到登录界面
 */
function checkLogin() {
    session_start();
    if (empty($_SESSION['username'])){
        header("Location: login.html");
    }
}