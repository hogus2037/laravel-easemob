<h1 align="center"> laravel-easemob </h1>

<p align="center"> 环信即时通讯服务端SDK集成.</p>


## Installing

```shell
$ composer require hogus/laravel-easemob -vvv
```

## Usage

---
### 注册
`Easemob::getToken(); // 获取Token `  
`Easemob::login($username, $password); // 登陆获取用户token`

`Easemob::register($username, $password); //开放注册`  
`Easemob::authorizedRegister($username, $password); // 授权注册`  
`Easemob::batchRegister($users, $auth = false);// 批量注册 是否使用授权`  

---
###发送消息
```php
//发送文本消息
Easemob::messages('text')->target_type('users')->to('user2')->content('文本内容')->from('user1')->send();
//发送图片
Easemob::messages('img')->target_type('users')->to('user2')->uuid('上传后得到uuid')->filename('文件名')->secret('上传后得到的secret')->width('图片宽')->height('图片高')->from('user1')->send();
//发送语音消息
//发送视频消息
//发送透传消息
```
你还可以
```php
$data = [
    'target_type' => 'users',
    'content' => '文本内容', 
    'from' => 'user1',
    'to' => 'user2'
];
Easemob::messages('text')->sendData($data);
```
---
###上传下载
```php
//上传文件
Easemob::uploadFile($filePath, $access = false);

//下载文件
Easemob::downloadFile($uuid, $shareSecret, $isThumbnail = false)->save($directory, $filename);
```
---
###用户管理
TODO

---
###群组管理
TODO

---
###聊天室管理
TODO


## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/hogus/laravel-easemob/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/hogus/laravel-easemob/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT
