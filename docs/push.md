# 全员推送

---

## 全员推送

```php
$tim->push->setTIMTextElem('大家好吗')->pushAllMember();
// 其他参数
$tim->message
    ->setTIMTextElem('在吗') // 设置文本消息
    ->setTIMLocationElem('someinfo', 29.340656774469956, 116.77497920478824) // 设置地理位置消息
    ->setTIMFaceElem(1, 'content') // 设置表情消息
    ->setTIMCustomElem('message', 'notification', 'url', 'dingdong.aiff') // 设置自定义消息
    ->setTIMSoundElem('sound_url') // 设置语音消息
    ->setTIMImageElem('image_url') // 设置图像消息
    ->setTIMFileElem('file_url') // 设置文件消息
    ->setTIMVideoFileElem('video_url', 'thumb_url') // 设置视频消息
    ->tagsAnd(['股票A', '股票B'])
    ->tagsOr(['股票A', '股票B'])
    ->attrsAnd(['会员等级' => '超白金会员', 'city' => '深圳'])
    ->attrsOr(['会员等级' => '超白金会员', 'city' => '深圳'])
    ->setOfflinePushInfo(new OfflinePushInfo(0, '这是推送标题', '这是离线推送内容', '这是透传的内容')) // 离线推送信息配置
    ->pushAllMember('101', 86400);
```

## 设置应用属性名称

```php
$tim->setAppAttr([
    '0' => 'sex',
    '1' => 'city',
    '2' => 'country'
]);
```

## 获取应用属性名称

```php
$tim->getAppAttr();
```

## 获取用户属性

```php
$tim->getUserAttr(['101', 102]);
$tim->getUserAttr('101');
```

## 设置用户属性

```php
$tim->setUserAttr([
    '101' => [
        'sex'  => 'attr1',
        'city' => 'attr2',
    ],
    '102' => [
        'sex'  => 'attr3',
        'city' => 'attr4',
    ]
]);
```

## 删除用户属性

```php
$tim->removeUserAttr([
    '101' => [
        'sex',
        'city',
    ],
    '102' => [
        'sex',
        'city',
    ]
]);
```

## 获取用户标签

```php
$tim->getUserTag(['101', 102]);
$tim->getUserTag('101');
```

## 添加用户标签

```php
$tim->setUserTag([
    '101' => [
        'a',
        'b',
    ],
    '102' => [
        'a',
        'b',
    ]
]);
```

## 删除用户标签

```php
$tim->removeUserTag([
    '101' => [
        'a',
        'b',
    ],
    '102' => [
        'a',
        'b',
    ]
]);
```

## 删除用户所有标签

```php
$tim->removeUserAllTags(['101', 102]);
$tim->removeUserAllTags('101');
```