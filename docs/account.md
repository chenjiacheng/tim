# 帐号管理

---

## 导入单个帐号

```php
$tim->account->import('101');
$tim->account->import('102', 'user102', 'https://avatars.githubusercontent.com/u/15870542');
```

## 导入多个帐号

```php
$tim->account->multiImport(['101', '102']);
```

## 删除帐号

```php
$tim->account->delete(['101', '102']);
$tim->account->delete('101');
```

## 查询帐号

```php
$tim->account->check(['101', '102']);
$tim->account->check('101');
```

## 失效帐号登录态

```php
$tim->account->kick('101');
```

## 查询帐号在线状态

```php
$tim->account->queryStatus(['101', '102']);
$tim->account->queryStatus('101', true);
```