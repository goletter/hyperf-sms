<?php

declare(strict_types=1);

namespace Goletter\Sms\Contract;

interface MessageInterface
{
    /**
     * 返回消息的模板id
     * @param SmsInterface $sms
     * @return string
     */
    public function getTemplate(SmsInterface $sms): string;

    /**
     * 返回消息内容
     * @param SmsInterface $sms
     * @return string
     */
    public function getContent(SmsInterface $sms): string;

    /**
     * 返回消息的模板数据
     * @param SmsInterface $sms
     * @return array
     */
    public function getData(SmsInterface $sms): array;
}