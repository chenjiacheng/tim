# 群组管理

---

## 获取 App 中的所有群组

```php
$tim->group->getAll();
$tim->group->getAll(100, 0, GroupType::CHAT_ROOM);
```

## 创建群组

```php
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
```

## 获取群详细资料

```php
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
```

## 获取群成员详细资料

```php
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
```

## 修改群基础资料

```php
$tim->group->modify('@100001');
$tim->group->modify('@100001', 'group100001', GroupMuteAllMember::OFF, new GroupInfo('简介', '公告'));
```

## 增加群成员

```php
$tim->group->addMember('@100001', ['103', 104]);
$tim->group->addMember('@100001', ['105', 106], true);
```

## 删除群成员

```php
$tim->group->deleteMember('@100001', ['103', 104]);
$tim->group->deleteMember('@100001', ['105', 106], '违规删除', true);
```

## 修改群成员资料

```php
$tim->group->modifyMember('@100001', '101', GroupMemberRole::MEMBER);
$tim->group->modifyMember('@100001', '101',
    GroupMemberRole::MEMBER,
    GroupMsgFlag::ACCEPT_AND_NOTIFY,
    '群名片昵称',
    [
        "Key"   => "MemberDefined",
        "Value" => "ModifyData"
    ], 86400);
```

## 解散群组

```php
$tim->group->destroy('@100001');
```

## 获取用户所加入的群组

```php
$tim->group->getJoinedGroupList('101');
```

## 查询用户在群组中的身份

```php
$tim->group->getRoleInGroup('@100001', ['101', 102]);
$tim->group->getRoleInGroup('@100001', '101');
```

## 批量禁言和取消禁言

```php
$tim->group->forbidSendMsg('@100001', ['101', 102], 86400);
$tim->group->forbidSendMsg('@100001', '101', 0);
```

## 获取被禁言群成员列表

```php
$tim->group->getMutedAccount('@100001');
```

## 在群组中发送普通消息

```php
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
```

## 在群组中发送系统通知

```php
$tim->group->sendSystemNotification('@100001', '系统通知');
$tim->group->sendSystemNotification('@100001', '系统通知', ['101', 102]);
```

## 撤回群消息

```php
$tim->group->groupMsgRecall('@100001', ['xx']);
```

## 转让群主

```php
$tim->group->changeOwner('@100001', '102');
```

## 导入群基础资料

```php
$tim->group->import('group11');
$tim->group->import('group14', GroupType::CHAT_ROOM, 101, '@100002', time(), new GroupInfo('简介', '公告'));
```

## 导入群消息

```php
$tim->group->importMsg('@100001', new GroupMsgList(
    (new GroupMsgItem('101', time() - 86400))->setTIMTextElem('hello'),
    (new GroupMsgItem('101', time() - 86400))->setTIMLocationElem('深圳', 114.05, 22.55),
));
```

## 导入群成员

```php
$tim->group->importMember('@100001', new GroupMemberList(
    (new GroupMemberItem('101')),
    (new GroupMemberItem('102', 'Admin', time(), 10)),
));
```

## 设置成员未读消息计数

```php
$tim->group->setUnreadMsgNum('@100001', '101', 10);
```

## 删除指定用户发送的消息

```php
$tim->group->deleteMsgBySender('@100001', '101');
```

## 拉取群历史消息

```php
$tim->group->getHistory('@100001');
$tim->group->getHistory('@100001', 10);
```

## 获取直播群在线人数

```php
$tim->group->getOnlineMemberNum('@100001');
```

## 获取直播群在线成员列表

```php
$tim->group->getMembers('@100001');
```

## 获取群自定义属性

```php
$tim->group->getAttr('@100001');
```

## 修改群自定义属性

```php
$tim->group->modifyAttr('@100001', [
    'attr_key1' => 'attr_val1',
    'attr_key2' => 'attr_val2',
]);
```

## 清空群自定义属性

```php
$tim->group->clearAttr('@100001');
```

## 重置群自定义属性

```php
$tim->group->setAttr('@100001', [
    'attr_key1' => 'attr_val1',
    'attr_key2' => 'attr_val2',
]);
```

## 修改群聊历史消息

```php
$tim->group->setTIMTextElem('hello')->modifyMsg('@100001', 10000);
```

## 拉取群消息已读回执详情

```php
$tim->group->getGroupMsgReceiptDetail('@100001');+
```

## 拉取群消息已读回执信息

```php
$tim->group->getGroupMsgReceipt('@100001', [1, 2, 3]);
```

## 直播群广播消息

```php
$tim->group->setTIMTextElem('hello')->sendBroadcastMsg('101');
```

## 创建话题

```php
$tim->group->createTopic('@100001', 'topic1');
$tim->group->createTopic('@100001', 'topic2',
    '@TGS#_@TGS#cQVLVHIM62CJ@TOPIC#_TestTopic',
    '101', 'This is a custom string',
    new TopicInfo('http://this.is.face.url',
        'This is topic Notification',
        'This is topic Introduction', [
            'TopicTestData1' => 'xxxxx',
            'TopicTestData2' => 'abc\u0000\u0001'
        ]));
```

## 解散话题

```php
$tim->group->destroyTopic('@100001', ['aaa', 'bbb']);
$tim->group->destroyTopic('@100001', 'ccc');
```

## 获取话题资料

```php
$tim->group->getTopic('@100001', '101');
$tim->group->getTopic('@100001', '101', ['aaa', 'bbb']);
```

## 修改话题资料

```php
$tim->group->modifyTopic('@100001', '@TGS#_@TGS#cQVLVHIM62CJ@TOPIC#_TestTopic', 'topicName');
$tim->group->modifyTopic('@100001', '@TGS#_@TGS#cQVLVHIM62CJ@TOPIC#_TestTopic', 'topicName',
    '101', 'This is a custom string', true,
    new TopicInfo('http://this.is.face.url',
        'This is topic Notification',
        'This is topic Introduction', [
            'TopicTestData1' => 'xxxxx',
            'TopicTestData2' => 'abc\u0000\u0001'
        ]));
```