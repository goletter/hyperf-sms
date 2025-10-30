<?php

declare(strict_types=1);

namespace Goletter\Sms\Contract;

use Exception;

interface SmsInterface
{
    /**
     * 发送短信
     * @param string $mobile
     * @param array $message
     * @return void
     * @throws Exception
     */
    public function send(string $mobile, array $message): void;

    /**
     * 获取驱动
     * @return string
     */
    public function getDriver(): string;

    /**
     * 获取名称
     * @return string
     */
    public function getName(): string;
}