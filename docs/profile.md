# 资料管理

---

## 设置资料

```php
$tim->profile->set('101', [
    ProfileTag::NICK     => 'user101',
    ProfileTag::GENDER   => ProfileGenderType::MALE,
    ProfileTag::BIRTHDAY => 20220801,
    // ...
]);
```

## 获取资料

```php
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