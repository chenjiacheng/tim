# 单聊消息

---

## 单发单聊消息

```php
$tim->message->setTIMTextElem('你好')->sendMsg('101'); // 发送文本消息
$tim->message->setTIMLocationElem('someinfo', 29.340656774469956, 116.77497920478824)->sendMsg('101'); // 发送地理位置消息
// 其他参数
$tim->message
    ->setTIMTextElem('在吗') // 设置文本消息
    ->setTIMLocationElem('someinfo', 29.340656774469956, 116.77497920478824) // 设置地理位置消息
    ->setTIMFaceElem(1, 'content') // 设置表情消息
    ->setTIMCustomElem('message', 'notification', 'url', 'dingdong.aiff') // 设置自定义消息
    ->setTIMSoundElem('sound_url') // 设置语音消息
    ->setTIMImageElem('image_url') // 设置图像消息
    ->setTIMImageElem([
        [
            'type'   => 1, // 原图
            'size'   => 1853095,
            'width'  => 2448,
            'height' => 3264,
            'url'    => 'http://xxx/3200490432214177468_144115198371610486_D61040894AC3DE44CDFFFB3EC7EB720F/0',
        ],
        [
            'type'   => 2, // 大图
            'size'   => 2565240,
            'width'  => 0,
            'height' => 0,
            'url'    => 'http://xxx/3200490432214177468_144115198371610486_D61040894AC3DE44CDFFFB3EC7EB720F/720',
        ],
        [
            'type'   => 3, // 缩略图
            'size'   => 12535,
            'width'  => 0,
            'height' => 0,
            'url'    => 'http://xxx/3200490432214177468_144115198371610486_D61040894AC3DE44CDFFFB3EC7EB720F/198',
        ]
    ]) // 设置图像消息
    ->setTIMFileElem('file_url') // 设置文件消息
    ->setTIMVideoFileElem('video_url', 'thumb_url') // 设置视频消息
    ->setTIMVideoFileElem([
        'url'    => 'https://0345-1400187352-1256635546.cos.ap-shanghai.myqcloud.com/abcd/f7c6ad3c50af7d83e23efe0a208b90c9',
        'uuid'   => '5da38ba89d6521011e1f6f3fd6692e35',
        'size'   => 1194603,
        'second' => 5,
        'format' => 'mp4',
    ], [
        'url'    => 'https://0345-1400187352-1256635546.cos.ap-shanghai.myqcloud.com/abcd/a6c170c9c599280cb06e0523d7a1f37b',
        'uuid'   => '6edaffedef5150684510cf97957b7bc8',
        'size'   => 13907,
        'width'  => 720,
        'height' => 1280,
        'format' => 'JPG',
    ]) // 设置视频消息
    ->setCloudCustomData('云端保存消息') // 消息自定义数据（云端保存，会发送到对端，程序卸载重装后还能拉取到）
    ->beforeCallback(false) // 表示禁止发消息前回调
    ->afterCallback(false) // 表示禁止发消息后回调
    ->noUnread(true) // 表示该条消息不计入未读数
    ->noLastMsg(true) // 表示该条消息不更新会话列表
    ->withMuteNotifications(true) // 表示该条消息的接收方对发送方设置的免打扰选项生效（默认不生效）
    ->setOfflinePushInfo(new OfflinePushInfo(0, '这是推送标题', '这是离线推送内容', '这是透传的内容')) // 离线推送信息配置
    ->sendMsg(101, '102', false, 86400);
```

## 批量发单聊消息

```php
$tim->message->setTIMTextElem('你好')->batchSendMsg(['101', '102']); // 批量发送文本消息
$tim->message->setTIMLocationElem('someinfo', 29.340656774469956, 116.77497920478824)->batchSendMsg(['101', '102']); // 批量发送地理位置消息
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
    ->setCloudCustomData('云端保存消息') // 消息自定义数据（云端保存，会发送到对端，程序卸载重装后还能拉取到）
    ->noUnread(true) // 表示该条消息不计入未读数
    ->noLastMsg(true) // 表示该条消息不更新会话列表
    ->withMuteNotifications(true) // 表示该条消息的接收方对发送方设置的免打扰选项生效（默认不生效）
    ->setOfflinePushInfo(new OfflinePushInfo(0, '这是推送标题', '这是离线推送内容', '这是透传的内容')) // 离线推送信息配置
    ->batchSendMsg(['101', 103], '102', false, 86400);
```

## 导入单聊消息

```php
$tim->message->setTIMTextElem('你好')->importMsg('101', '102');
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
    ->setCloudCustomData('云端保存消息') // 消息自定义数据（云端保存，会发送到对端，程序卸载重装后还能拉取到）
    ->noUnread(true) // 表示该条消息不计入未读数
    ->noLastMsg(true) // 表示该条消息不更新会话列表
    ->withMuteNotifications(true) // 表示该条消息的接收方对发送方设置的免打扰选项生效（默认不生效）
    ->setOfflinePushInfo(new OfflinePushInfo(0, '这是推送标题', '这是离线推送内容', '这是透传的内容')) // 离线推送信息配置
    ->importMsg('101', 102, time(), false);
```

## 查询单聊消息

```php
$tim->message->getRoamMsg('101', 102, 100, time() - 86400, time());
```

## 撤回单聊消息

```php
$tim->message->msgWithdraw('101', 102, '31906_833502_1572869830');
```

## 设置单聊消息已读

```php
$tim->message->setMsgRead('101', 102);
```

## 查询单聊未读消息计数

```php
$tim->message->getUnreadMsgNum('101', [102, '103']);
$tim->message->getUnreadMsgNum('101', 102);
```

## 修改单聊历史消息

```php
$tim->message
    ->setCloudCustomData('云端保存消息') // 消息自定义数据（云端保存，会发送到对端，程序卸载重装后还能拉取到）
    ->modifyMsg('101', 102, '31906_833502_1572869830');
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
    ->setCloudCustomData('云端保存消息') // 消息自定义数据（云端保存，会发送到对端，程序卸载重装后还能拉取到）
    ->modifyMsg('101', 102, '31906_833502_1572869830');
```