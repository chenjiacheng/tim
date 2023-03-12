# 第三方回调

---

## 回调签名校验

```php
$tim->callback->verify('sign', 'requestTime', 'token');
```

## 回调处理成功应答

```php
$tim->callback->ok();
```

## 回调处理失败应答

```php
$tim->callback->fail();
```