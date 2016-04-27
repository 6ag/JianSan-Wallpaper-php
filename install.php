<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 16/4/25
 * Time: 12:20
 */

include_once 'common.php';

// 创建用户数据表
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS jf_user (
    id INT NOT NULL AUTO_INCREMENT KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password CHAR(32) NOT NULL
)
EOF;

if (!$pdo->query($sql)) {
    exit('创建用户表失败');
}

// 创建壁纸数据表
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS jf_wallpaper (
    id INT NOT NULL AUTO_INCREMENT KEY,
    category VARCHAR(10) NOT NULL,
    path VARCHAR(80) NOT NULL
)
EOF;

if (!$pdo->query($sql)) {
    exit('创建壁纸数据表失败');
}

// 创建意见反馈数据表
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS jf_feedback (
    id INT NOT NULL AUTO_INCREMENT KEY,
    contact VARCHAR(100) NOT NULL,
    content TEXT NOT NULL
)
EOF;

if (!$pdo->query($sql)) {
    exit('创建意见反馈数据表失败');
}

// 配置文件里的初始用户
$username = $config['initUsername'];
$password = $config['initPassword'];

// 查询用户
$sql = "SELECT * FROM jf_user WHERE username=\"$username\"";

if ($pdo->getOne($sql)) {
    header("Location: login.html");
    exit;
}

// 添加用户
$sql = "INSERT INTO jf_user (username, password) VALUES (\"$username\", md5(\"$password\"));";

if (!$pdo->query($sql)) {
    exit('添加账户' . $username . '失败');
}

// 跳转到登录界面
jumpToPage('login.html', '安装成功,用户名:' . $username . ' 密码:' . $password . ', 正在跳转...');