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
$tim->account->queryStatus('101');
```

单聊消息

全员推送

资料管理

```php
// 设置资料
$tim->profile->set('101', [
    ProfileTag::NICK              => 'user101',
    ProfileTag::GENDER            => ProfileGenderType::MALE,
    ProfileTag::BIRTHDAY          => 20220801,
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

// 删除单个C2C会话
$tim->contact->deleteC2C('101', '102');

// 删除单个G2C会话
$tim->contact->deleteG2C('101', '@#123456');
```

群组管理

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
```

## License

MIT