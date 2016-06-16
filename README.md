# 剑三APP后台管理系统

## 项目结构

+ *assets*   -----各种网页资源
+ initdata ----- 初始数据 (可删除)
+ *resource* -----存放壁纸文件
+ common.php -----公共脚本
+ config.php -----项目配置脚本
+ feedback.php ----- 反馈信息接口
+ getwallpaper.php -----获取壁纸数据接口
+ index.php -----后台主页
+ initdata.php ----- 初始化项目数据脚本
+ install.php -----安装项目
+ login.php ----- 登录脚本
+ MySQLDB.class.php -----数据库封装类
+ upload.php ----- 上传壁纸脚本

## 如何使用

### 上传项目

下载项目文件和初始数据压缩包 *initdata.zip*，并上传至您的服务器，然后解压缩。

### 配置数据

配置您的数据库信息和后台账户信息，如需初始数据请确保初始数据路径是否正确。

```php
return $config = [
                  // 初始数据路径
                  'initdataPath' => './initdata',
                  // 数据库信息
                  'username' => 'root',
                  'password' => 'root',
                  'dbname' => 'jiansan',
                  
                  // 初始化安装的账号密码
                  'initUsername' => 'admin',
                  'initPassword' => 'admin888'
                  ];
```

### 安装程序

在浏览器访问服务器上的 `install.php` 脚本，进行程序安装。

### 初始数据

**注意:** 这一步是需求才进行，如果不需要直接跳过。
在浏览器访问服务器上的 `initdata.php` 脚本，进行数据初始化。

### 后台管理

登录后台后，可以进行壁纸上传管理。

### APP获取壁纸数据

数据接口: `getwallpaper.php` 

请求方式: `get`

必要参数: `category` 分类， `currentPage` 当前页码

可选参数: `onePageCount` 每页壁纸数量

可选参数: `news` 随便传个值，调用新接口，返回数据带缩略图字段

请求示例:

```swift
// 接口 get方式可以拼接参数到url上
http://xxxx.com/getwallpaper.php?new=1&category=tc&currentPage=1
```

返回示例:

```json
{
    "code": 1,
    "message": "成功",
    "data": [
        {
            "id": "336",
            "category": "tc",
            "path": "resource/tc/f8e63d65906c06bf89d874d0c5f96c46.png",
            "smallpath": "resource/tc/smallf8e63d65906c06bf89d874d0c5f96c46.png"
        },
        {
            "id": "335",
            "category": "tc",
            "path": "resource/tc/522526abc4fc5399fcb61c594df91b1d.png",
            "smallpath": "resource/tc/small522526abc4fc5399fcb61c594df91b1d.png"
        },
        {
            "id": "334",
            "category": "tc",
            "path": "resource/tc/eaf365f46461b81146f89277a051be46.png",
            "smallpath": "resource/tc/smalleaf365f46461b81146f89277a051be46.png"
        },
        {
            "id": "305",
            "category": "tc",
            "path": "resource/tc/c6cc012aad69628113fcfadf79d7dbf2.png",
            "smallpath": "resource/tc/smallc6cc012aad69628113fcfadf79d7dbf2.png"
        },
        {
            "id": "304",
            "category": "tc",
            "path": "resource/tc/505e4cc96e26f8d86409dc781a092c9b.png",
            "smallpath": "resource/tc/small505e4cc96e26f8d86409dc781a092c9b.png"
        },
        {
            "id": "270",
            "category": "tc",
            "path": "resource/tc/22945d1179e02bd7ba1255714e800286.png",
            "smallpath": "resource/tc/small22945d1179e02bd7ba1255714e800286.png"
        },
        {
            "id": "252",
            "category": "tc",
            "path": "resource/tc/bd4f3c89891f94fd50918d4bc008e8e4.png",
            "smallpath": "resource/tc/smallbd4f3c89891f94fd50918d4bc008e8e4.png"
        },
        {
            "id": "163",
            "category": "tc",
            "path": "resource/tc/a21d4ebb91c1056415e54721ae81a64d.png",
            "smallpath": "resource/tc/smalla21d4ebb91c1056415e54721ae81a64d.png"
        },
        {
            "id": "162",
            "category": "tc",
            "path": "resource/tc/b29c8d991a87e6e552810a9913724fe0.png",
            "smallpath": "resource/tc/smallb29c8d991a87e6e552810a9913724fe0.png"
        },
        {
            "id": "161",
            "category": "tc",
            "path": "resource/tc/8d7815eaf5e9d0d296dd10d2e9cb0931.png",
            "smallpath": "resource/tc/small8d7815eaf5e9d0d296dd10d2e9cb0931.png"
        }
    ]
}
```

### APP提交反馈信息

数据接口: `feedback.php` 

请求方式: `post`

必要参数: `contact` 联系方式， `content` 反馈内容

请求示例:

```swift
// 接口
https://xxxx.com/feedback.php

// 参数
let parameters = [
            "content" : "这是一条测试反馈内容，应该成功的",
            "contact" : "44334512"
        ]
```

返回示例:

```json
{
	"code": 1,
	"message": "提交反馈成功"
}
```

### 吃了一斤

数据数据太大了，github传不上来，请访问 [我的博客](https://blog.6ag.cn/) 下载或发送邮件到 <admin@6ag.cn> 获取。

