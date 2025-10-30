<?php

return [
    // 默认驱动
    'default' => 'aliyun',
    'driver'  => [
        'aliyun'     => [
            'name'   => '阿里云短信',
            'driver' => \Webguosai\HyperfSms\Driver\Aliyun::class,
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
            'driver' => \Webguosai\HyperfSms\Driver\Qiniu::class,
            // 驱动初始化参数
            'config' => [
                'access_key' => '',
                'secret_key' => '',
            ]
        ],
        'smschinese' => [
            'name'   => '中国网建',
            'driver' => \Webguosai\HyperfSms\Driver\Smschinese::class,
            'config' => [
                'uid' => '',
                'key' => '',
            ]
        ],
    ]
];
