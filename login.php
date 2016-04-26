<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 16/4/25
 * Time: 01:36
 */

include_once 'common.php';

$username = $_POST['username'];
$password = $_POST['password'];

// 验证登录信息
$sql = "SELECT * FROM jf_user WHERE username=\"$username\"";
if ($result = $pdo->getRow($sql)) {
    if (md5($password) == $result['password']) {
        session_start();
        $_SESSION['username'] = $username;
        jumpToPage('index.php', '登录成功,正在跳转...');
    } else {
        jumpToPage('login.html', '密码错误,返回登录界面...');
    }
} else {
    jumpToPage('login.html', '没有找到' . $username . '用户');
}