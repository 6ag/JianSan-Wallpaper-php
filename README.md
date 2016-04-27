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

请求示例:

```swift
// 接口 get方式可以拼接参数到url上
https://xxxx.com/getwallpaper.php?category=tc&currentPage=1
```

返回示例:

```json
{
	"code": 1,
	"message": "成功",
	"data": [{
		"id": "163",
		"category": "tc",
		"path": "resource\/tc\/23ac9e41b3d47fecaaba83dcd9422765.png"
	}, {
		"id": "162",
		"category": "tc",
		"path": "resource\/tc\/9d61c30f5f52731f6b1a155651f7bd11.png"
	}, {
		"id": "161",
		"category": "tc",
		"path": "resource\/tc\/ab1c2956f5ddd95a049f66dcdce96028.png"
	}, {
		"id": "160",
		"category": "tc",
		"path": "resource\/tc\/4a3fa795911455fca8768aea9d9b68c4.png"
	}, {
		"id": "159",
		"category": "tc",
		"path": "resource\/tc\/a577eb5c77528f288f9434baf2e46af7.png"
	}, {
		"id": "158",
		"category": "tc",
		"path": "resource\/tc\/56a1f3ac7ab59d5da9557fb695eb1df0.png"
	}, {
		"id": "157",
		"category": "tc",
		"path": "resource\/tc\/0811b933654b780ef8d2077b10490bc4.png"
	}, {
		"id": "156",
		"category": "tc",
		"path": "resource\/tc\/12920de656272b109040a5eda88805fe.png"
	}, {
		"id": "155",
		"category": "tc",
		"path": "resource\/tc\/5ee1b1039619cc89aa0f7cace730cee0.png"
	}, {
		"id": "154",
		"category": "tc",
		"path": "resource\/tc\/1e05b061c2e48868c77dd9215e3d34e3.png"
	}]
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

