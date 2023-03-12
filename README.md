# Tim

腾讯云 即时通信 IM SDK for PHP

[![Latest Stable Version](https://poser.pugx.org/chenjiacheng/tim/v/stable.svg)](https://packagist.org/packages/chenjiacheng/tim)
[![Latest Unstable Version](https://poser.pugx.org/chenjiacheng/tim/v/unstable.svg)](https://packagist.org/packages/chenjiacheng/tim)
[![Total Downloads](https://poser.pugx.org/chenjiacheng/tim/downloads)](https://packagist.org/packages/chenjiacheng/tim)
[![License](https://poser.pugx.org/chenjiacheng/tim/license)](https://packagist.org/packages/chenjiacheng/tim)

Laravel 扩展包：[传送门](https://github.com/chenjiacheng/laravel-tim)

Hyperf 扩展包：[传送门](https://github.com/chenjiacheng/hyperf-tim)

## 运行环境

- PHP >= 8.0.2
- [Composer](https://getcomposer.org/) >= 2.0

## 相关文档

[https://chenjiacheng.github.io/tim](https://chenjiacheng.github.io/tim)

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

## License

MIT