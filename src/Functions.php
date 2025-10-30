<?php

declare(strict_types=1);

namespace Goletter\Sms;

use Hyperf\Context\ApplicationContext;
use Goletter\Sms\Contract\SmsInterface;

if (!function_exists('Webguosai\HyperfSms\sms')) {
    /**
     * 获取APP应用请求实例.
     */
    function sms(): SmsInterface
    {
        $container = ApplicationContext::getContainer();

        return $container->get(SmsInterface::class);
    }
}