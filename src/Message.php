<?php

namespace Goletter\Sms;

use Goletter\Sms\Contract\MessageInterface;
use Goletter\Sms\Contract\SmsInterface;
use Closure;

class Message implements MessageInterface
{
    protected string|Closure $template;
    protected string|Closure $content;
    protected array|Closure $data;

    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $property => $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }

    /**
     * 返回消息的模板id
     * @param SmsInterface $sms
     * @return string
     */
    public function getTemplate(SmsInterface $sms): string
    {
        return is_callable($this->template) ? call_user_func($this->template, $sms->getDriver()) : $this->template;
    }

    /**
     * 返回消息内容
     * @param SmsInterface $sms
     * @return string
     */
    public function getContent(SmsInterface $sms): string
    {
        return is_callable($this->content) ? call_user_func($this->content, $sms->getDriver()) : $this->content;
    }

    /**
     * 返回消息的模板数据
     * @param SmsInterface $sms
     * @return array
     */
    public function getData(SmsInterface $sms): array
    {
        return is_callable($this->data) ? call_user_func($this->data, $sms->getDriver()) : $this->data;
    }
}