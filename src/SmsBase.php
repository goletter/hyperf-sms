<?php

namespace Goletter\Sms;

use Goletter\Sms\Contract\MessageInterface;

class SmsBase
{
    public function __construct(protected array $config, protected string $driver, protected string $name)
    {
    }

    /**
     * 获取驱动
     * @return string
     */
    public function getDriver(): string
    {
        return $this->driver;
    }

    /**
     * 获取名称
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * 格式化message
     * @param array $message
     * @return MessageInterface
     */
    protected function formatMessage(array $message): MessageInterface
    {
        return new Message($message);
    }

}