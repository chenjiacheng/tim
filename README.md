# Tim

腾讯云 即时通信 IM SDK for PHP

## 运行环境

- PHP >= 8.0.2
- [Composer](https://getcomposer.org/) >= 2.0

## 安装方式

```bash
composer require chenjiacheng/tim
```

## 使用示例

```php
// 配置信息
$config = [
    'sdkappid'   => '1400000000',
    'key'        => 'd182df719a269501ec4795f980aa3691cae60412335058c161c3467d3cb0f565',
    'identifier' => 'administrator',
];

// 实例化对象
$tim = new Tim($config);
```

帐号管理

```php
// 导入单个帐号
$tim->account->import('101');
$tim->account->import('102', 'user102', 'https://avatars.githubusercontent.com/u/15870542');

// 导入多个帐号
$tim->account->multiImport(['101', '102']);

// 删除帐号
$tim->account->delete(['101', '102']);
$tim->account->delete('101');

// 查询帐号
$tim->account->check(['101', '102']);
$tim->account->check('101');

// 失效帐号登录态
$tim->account->kick('101');

// 查询帐号在线状态
$tim->account->queryStatus(['101', '102']);
$tim->account->queryStatus('101', true);
```

单聊消息

```php
// 单发单聊消息
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

// 批量发单聊消息
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

// 导入单聊消息
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

// 查询单聊消息
$tim->message->getRoamMsg('101', 102, 100, time() - 86400, time());

// 撤回单聊消息
$tim->message->msgWithdraw('101', 102, '31906_833502_1572869830');

// 设置单聊消息已读
$tim->message->setMsgRead('101', 102);

// 查询单聊未读消息计数
$tim->message->getUnreadMsgNum('101', [102, '103']);
$tim->message->getUnreadMsgNum('101', 102);

// 修改单聊历史消息
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

全员推送

```php
// 全员推送
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

// 设置应用属性名称
$tim->setAppAttr([
    '0' => 'sex',
    '1' => 'city',
    '2' => 'country'
]);

// 获取应用属性名称
$tim->getAppAttr();

// 获取用户属性
$tim->getUserAttr(['101', 102]);
$tim->getUserAttr('101');

// 设置用户属性
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

// 删除用户属性
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

// 获取用户标签
$tim->getUserTag(['101', 102]);
$tim->getUserTag('101');

// 添加用户标签
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

// 删除用户标签
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

// 删除用户所有标签
$tim->removeUserAllTags(['101', 102]);
$tim->removeUserAllTags('101');
```

资料管理

```php
// 设置资料
$tim->profile->set('101', [
    ProfileTag::NICK     => 'user101',
    ProfileTag::GENDER   => ProfileGenderType::MALE,
    ProfileTag::BIRTHDAY => 20220801,
    // ...
]);

// 获取资料
$tim->profile->get(['101', 102], [
    ProfileTag::NICK,
    ProfileTag::GENDER,
    ProfileTag::BIRTHDAY,
    // ...
]);
$tim->profile->get('101', [
    ProfileTag::NICK,
    ProfileTag::GENDER,
    ProfileTag::BIRTHDAY,
    // ...
]);
```

关系链管理

```php
// 添加好友
$tim->sms->friend('101')->add([
    [
        'To_Account' => '102',
    ],
    [
        'To_Account' => '103',
        'Remark'     => 'remark1',
        'GroupName'  => '同学',
        'AddSource'  => 'AddSource_Type_XXXXXXXX',
        'AddWording' => 'Im Test1'
    ],
]);

// 导入好友
$tim->sms->friend('101')->import([
    [
        'To_Account' => '104',
        'AddSource'  => 'AddSource_Type_XXXXXXXX',
    ],
    [
        'To_Account' => '105',
        'Remark'     => 'remark1',
        'RemarkTime' => time(),
        'GroupName'  => ['同学'],
        'AddSource'  => 'AddSource_Type_XXXXXXXX',
        'AddWording' => 'Im Test1',
        'AddTime'    => time(),
        /*'CustomItem' => [
            ['Tag' => 'Tag_SNS_Custom_XXXX', 'Value' => 'Test'],
            ['Tag' => 'Tag_SNS_Custom_YYYY', 'Value' => 0],
        ]*/
    ],
]);

// 更新好友
$tim->sms->friend('101')->update([
    [
        'To_Account' => '102',
        'SnsItem'    => [
            ['Tag' => FriendTag::GROUP, 'Value' => 'Test'],
            ['Tag' => FriendTag::REMARK, 'Value' => 'Test'],
        ]
    ],
    [
        'To_Account' => '103',
        'SnsItem'    => [
            ['Tag' => FriendTag::GROUP, 'Value' => ['Test']],
            ['Tag' => FriendTag::REMARK, 'Value' => 'Test'],
        ]
    ],
]);

// 删除好友
$tim->sms->friend('101')->delete(['102', 103]);
$tim->sms->friend('101')->delete('104');

// 删除所有好友
$tim->sms->friend('101')->deleteAll();

// 校验好友
$tim->sms->friend('101')->check(['102', 103]);
$tim->sms->friend('101')->check('104');

// 拉取好友
$tim->sms->friend('101')->get();

// 拉取指定好友
$tim->sms->friend('101')->getList(['102', 103], [
    ProfileTag::NICK,
    ProfileTag::GENDER,
    ProfileTag::BIRTHDAY,
    // ...
]);
$tim->sms->friend('101')->getList('104', [
    ProfileTag::NICK,
    ProfileTag::GENDER,
    ProfileTag::BIRTHDAY,
    // ...
]);

// 添加黑名单
$tim->sms->black('101')->add(['103', 104]);
$tim->sms->black('101')->add('105');

// 拉取黑名单
$tim->sms->black('101')->get();
$tim->sms->black(102)->get(0, 2);

// 检验黑名单
$tim->sms->black('101')->check(['103', 104]);
$tim->sms->black('101')->check('105', BlackCheckType::BOTH);

// 删除黑名单
$tim->sms->black('101')->delete(['103', 104]);
$tim->sms->black('101')->delete('105');

// 添加分组
$tim->sms->group('101')->add(['group1', 'group2']);
$tim->sms->group('101')->add('group3');

// 删除分组
$tim->sms->group('101')->get();
$tim->sms->group('101')->get(['group1', 'group2']);
$tim->sms->group('101')->get('group3', true);

// 拉取分组
$tim->sms->group('101')->delete(['group1', 'group2']);
$tim->sms->group('101')->delete('group3');
```

最近联系人

```php
// 拉取会话列表
$tim->contact->getList('101');

// 删除单个会话
$tim->contact->delete('101', '102'); // 删除单聊会话
$tim->contact->delete('101', '@#123456', ChatType::GROUP); // 删除群组会话
```

群组管理

```php
// 获取 App 中的所有群组
$tim->group->getAll();
$tim->group->getAll(100, 0, GroupType::CHAT_ROOM);

// 创建群组
$tim->group->create('group1');
$tim->group->create('group2', GroupType::PRIVATE);
$tim->group->create('group3', GroupType::CHAT_ROOM, '101');
$tim->group->create('group4', GroupType::CHAT_ROOM, 101, '@100001',
    [
        [
            'Member_Account' => $this->config['identifier'],
        ],
        [
            'Member_Account' => '101',
        ],
        [
            'Member_Account' => '102',
        ],
        [
            'Member_Account' => '103',
        ],
        [
            'Member_Account' => '104',
            /*'AppMemberDefinedData' => [
                ['Key' => 'MemberDefined3', 'Value' => 'MemberData3'],
                ['Key' => 'MemberDefined4', 'Value' => 'MemberData4'],
            ]*/
        ]
    ], new GroupInfo('简介', '公告'));

// 获取群详细资料
$tim->group->get(['@100001']);
$tim->group->get(['@100001'],
    new GroupInfoResponseFilter(
        [
            'Type',
            'Name',
            'Introduction',
            'Notification'
        ],
        [
            'Account',
            'Role',
        ],
    ));

// 获取群成员详细资料
$tim->group->getMember('@100001');
$tim->group->getMember('@100001', 200, 0, '',
    new GroupMemberResponseFilter(
        [
            'Role',
            'JoinTime',
            'MsgSeq',
            'MsgFlag',
            'LastSendMsgTime',
            'MuteUntil',
            'NameCard'
        ],
        [
            'Owner',
            'Member'
        ],
        [
            'MemberDefined1',
            'MemberDefined2'
        ]
    ));

// 修改群基础资料
$tim->group->modify('@100001');
$tim->group->modify('@100001', 'group100001', GroupMuteAllMember::OFF, new GroupInfo('简介', '公告'));

// 增加群成员
$tim->group->addMember('@100001', ['103', 104]);
$tim->group->addMember('@100001', ['105', 106], true);

// 删除群成员
$tim->group->deleteMember('@100001', ['103', 104]);
$tim->group->deleteMember('@100001', ['105', 106], '违规删除', true);

// 修改群成员资料
$tim->group->modifyMember('@100001', '101', GroupMemberRole::MEMBER);
$tim->group->modifyMember('@100001', '101',
    GroupMemberRole::MEMBER,
    GroupMsgFlag::ACCEPT_AND_NOTIFY,
    '群名片昵称',
    [
        "Key"   => "MemberDefined",
        "Value" => "ModifyData"
    ], 86400);

// 解散群组
$tim->group->destroy('@100001');

// 获取用户所加入的群组
$tim->group->getJoinedGroupList('101');

// 查询用户在群组中的身份
$tim->group->getRoleInGroup('@100001', ['101', 102]);
$tim->group->getRoleInGroup('@100001', '101');

// 批量禁言和取消禁言
$tim->group->forbidSendMsg('@100001', ['101', 102], 86400);
$tim->group->forbidSendMsg('@100001', '101', 0);

// 获取被禁言群成员列表
$tim->group->getMutedAccount('@100001');

// 在群组中发送普通消息
$tim->group->setTIMTextElem('大家好啊')->sendMsg('@100001', '101', GroupMsgPriority::Normal, false);
// 其他参数
$tim->group
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
    ->sendMsg('@100001', '101', GroupMsgPriority::Normal, false);

// 在群组中发送系统通知
$tim->group->sendSystemNotification('@100001', '系统通知');
$tim->group->sendSystemNotification('@100001', '系统通知', ['101', 102]);

// 撤回群消息
$tim->group->groupMsgRecall('@100001', ['xx']);

// 转让群主
$tim->group->changeOwner('@100001', '102');

// 导入群基础资料
$tim->group->import('group11');
$tim->group->import('group14', GroupType::CHAT_ROOM, 101, '@100002', time(), new GroupInfo('简介', '公告'));

// 导入群消息
$tim->group->importMsg('@100001', new GroupMsgList(
    (new GroupMsgItem('101', time() - 86400))->setTIMTextElem('hello'),
    (new GroupMsgItem('101', time() - 86400))->setTIMLocationElem('深圳', 114.05, 22.55),
));

// 导入群成员
$tim->group->importMember('@100001', new GroupMemberList(
    (new GroupMemberItem('101')),
    (new GroupMemberItem('102', 'Admin', time(), 10)),
));

// 设置成员未读消息计数
$tim->group->setUnreadMsgNum('@100001', '101', 10);

// 删除指定用户发送的消息


// 拉取群历史消息


// 获取直播群在线人数


// 获取群自定义属性


// 修改群自定义属性


// 清空群自定义属性


// 重置群自定义属性


// 修改群聊历史消息


// 直播群广播消息


```

全局禁言管理

```php
// 设置全局禁言
$tim->overall->setNoSpeaking('101', 86400, 86400);

// 查询全局禁言
$tim->overall->getNoSpeaking('101');
```

运营管理

```php
// 拉取运营数据
$tim->operate->getAppInfo();

$tim->operate->getAppInfo([
    OperateField::APP_NAME,
    OperateField::APP_ID,
    OperateField::COMPANY,
    // ...
]);

// 下载最近消息记录
$tim->operate->getHistory(date('YmdH', time() - 86400));

// 获取服务器 IP 地址
$tim->operate->getIPList();

// 聊天文件封禁
$tim->forbidIllegalObject('https://cos.ap-shanghai.myqcloud.com/005f-shanghai-360-shared-01-1256635546/76aa-1400152839/2f3b-2273451635034382/699eb4ee5ffa9aeb70627958766f2927-142072.jpg');

// 聊天文件解封
$tim->allowBannedObject('https://cos.ap-shanghai.myqcloud.com/98ec-shanghai-007-privatev2-01-1256635546/0345-1400187352/0612-yyy/9a0f4c42d208ccfb5aa47c29284aefc6.png');

// 聊天文件签名
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

## License

MIT