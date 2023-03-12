# 关系链管理

---

## 添加好友

```php
$tim->sns->friend('101')->add([
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
```

## 导入好友

```php
$tim->sns->friend('101')->import([
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
```

## 更新好友

```php
$tim->sns->friend('101')->update([
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
```

## 删除好友

```php
$tim->sns->friend('101')->delete(['102', 103]);
$tim->sns->friend('101')->delete('104');
```

## 删除所有好友

```php
$tim->sns->friend('101')->deleteAll();
```

## 校验好友

```php
$tim->sns->friend('101')->check(['102', 103]);
$tim->sns->friend('101')->check('104');
```

## 拉取好友

```php
$tim->sns->friend('101')->get();
```

## 拉取指定好友

```php
$tim->sns->friend('101')->getList(['102', 103], [
    ProfileTag::NICK,
    ProfileTag::GENDER,
    ProfileTag::BIRTHDAY,
    // ...
]);
$tim->sns->friend('101')->getList('104', [
    ProfileTag::NICK,
    ProfileTag::GENDER,
    ProfileTag::BIRTHDAY,
    // ...
]);
```

## 添加黑名单

```php
$tim->sns->black('101')->add(['103', 104]);
$tim->sns->black('101')->add('105');
```

## 拉取黑名单

```php
$tim->sns->black('101')->get();
$tim->sns->black(102)->get(0, 2);
```

## 检验黑名单

```php
$tim->sns->black('101')->check(['103', 104]);
$tim->sns->black('101')->check('105', BlackCheckType::BOTH);
```

## 删除黑名单

```php
$tim->sns->black('101')->delete(['103', 104]);
$tim->sns->black('101')->delete('105');
```

## 添加分组

```php
$tim->sns->group('101')->add(['group1', 'group2']);
$tim->sns->group('101')->add('group3');
```

## 删除分组

```php
$tim->sns->group('101')->get();
$tim->sns->group('101')->get(['group1', 'group2']);
$tim->sns->group('101')->get('group3', true);
```

## 拉取分组

```php
$tim->sns->group('101')->delete(['group1', 'group2']);
$tim->sns->group('101')->delete('group3');
```