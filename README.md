<h1 align="center">hyperf-sms</h1>

<p align="center">
<a href="https://packagist.org/packages/goletter/hyperf-sms"><img src="https://poser.pugx.org/goletter/hyperf-sms/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/goletter/hyperf-sms"><img src="https://poser.pugx.org/goletter/hyperf-sms/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/goletter/hyperf-sms"><img src="https://poser.pugx.org/goletter/hyperf-sms/v/unstable" alt="Latest Unstable Version"></a>
<a href="https://packagist.org/packages/goletter/hyperf-sms"><img src="https://poser.pugx.org/goletter/hyperf-sms/license" alt="License"></a>
</p>


## 运行环境

- php >= 8.1
- composer
- hyperf >= 3.1

## 安装

```bash
composer require goletter/hyperf-sms
```

## 配置

发布配置

```bash
php bin/hyperf.php vendor:publish goletter/hyperf-sms
```

配置文件

```php
return [
    // 默认驱动
    'default' => 'aliyun',
    'driver'  => [
        'aliyun'     => [
            'name'   => '阿里云短信',
            'driver' => \Goletter\Sms\Driver\Aliyun::class,
            'config' => [
                'accessKeyId'     => '',
                'accessKeySecret' => '',
                'regionId'        => '',
                'signName'        => '',
            ]
        ],
        'qiniu'      => [
            // 驱动名称
            'name'   => '七牛云短信',
            'driver' => \Goletter\Sms\Driver\Qiniu::class,
            // 驱动初始化参数
            'config' => [
                'access_key' => '',
                'secret_key' => '',
            ]
        ],
        'smschinese' => [
            'name'   => '中国网建',
            'driver' => \Goletter\Sms\Driver\Smschinese::class,
            'config' => [
                'uid' => '',
                'key' => '',
            ]
        ],
    ]
];
```

## 使用

### 发送短信

- **写法一**

```php
use function Goletter\Sms\sms;

sms()->send('18888888888', [
    'template' => 'xxx',
    'content' => '您的验证码是1234，该验证码1分钟内有效，请勿泄漏于他人！',
    'data' => [
        'code' => '1234'
    ]
]);
```

- **写法二**

```php
use Goletter\Sms\Contract\SmsInterface;

$sms = di(SmsInterface::class);
$sms->send('18888888888', [
    'template' => 'xxx',
    'content' => '您的验证码是1234，该验证码1分钟内有效，请勿泄漏于他人！',
    'data' => [
        'code' => '1234'
    ]
]);
```

### 获取信息

```php
use function Goletter\Sms\sms;

sms()->getName();

sms()->getDriver();
```

### 自定义驱动

```php
$sms = \Goletter\Sms\Facade\Sms::driver('qiniu');
// 或 
// $sms = \Webguosai\HyperfSms\Facade\Sms::make('qiniu');

$sms->send('18888888888', [
    'template' => 'xxx',
    'content' => '您的验证码是1234，该验证码1分钟内有效，请勿泄漏于他人！',
    'data' => [
        'code' => '1234'
    ]
]);
```

### 闭包发送

```php
use function Goletter\Sms\sms;

sms()->send('18888888888', [
    'content'  => function($driver){
        if ($driver == 'aliyun') {
            return '云片专用验证码：1235';
        }
        return '您的验证码为: 6379';
    },
    'template' => function($driver){
        if ($driver == 'aliyun') {
            return '1888883905033940992';
        }
        return 'SMS_001';
    },
    'data' => function($driver){
        return [
            'code' => 6379
        ];
    }
]);
```

## License

MIT
