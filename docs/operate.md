# 运营管理

---

## 拉取运营数据

```php
$tim->operate->getAppInfo();

$tim->operate->getAppInfo([
    OperateField::APP_NAME,
    OperateField::APP_ID,
    OperateField::COMPANY,
    // ...
]);
```

## 下载最近消息记录

```php
$tim->operate->getHistory(date('YmdH', time() - 86400));
```

## 获取服务器 IP 地址

```php
$tim->operate->getIPList();
```

## 聊天文件封禁

```php
$tim->forbidIllegalObject('https://cos.ap-shanghai.myqcloud.com/005f-shanghai-360-shared-01-1256635546/76aa-1400152839/2f3b-2273451635034382/699eb4ee5ffa9aeb70627958766f2927-142072.jpg');
```

## 聊天文件解封

```php
$tim->allowBannedObject('https://cos.ap-shanghai.myqcloud.com/98ec-shanghai-007-privatev2-01-1256635546/0345-1400187352/0612-yyy/9a0f4c42d208ccfb5aa47c29284aefc6.png');
```

## 聊天文件签名

```php
$tim->getCosSig([
    [
        'ResourceID' => 1,
        'RawURL'     => 'https://cos.ap-shanghai.myqcloud.com/98ec-shanghai-007-privatev2-01-1256635546/0345-1400187352/0612-yyy/9a0f4c42d208ccfb5aa47c29284aefc6.png',
    ],
    [
        'ResourceID' => 2,
        'RawURL'     => 'https://cos.ap-shanghai.myqcloud.com/98ec-shanghai-007-privatev2-01-1256635546/0345-1400187352/0612-yyy/9a0f4c42d208ccfb5aa47c29284aefc7.png',
    ]
]);
```