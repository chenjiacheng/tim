# 最近联系人

---

## 拉取会话列表

```php
$tim->contact->getList('101');
```

## 删除单个会话

```php
$tim->contact->delete('101', '102'); // 删除单聊会话
$tim->contact->delete('101', '@#123456', ChatType::GROUP); // 删除群组会话
```