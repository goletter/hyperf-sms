<?php

declare(strict_types=1);

namespace Goletter\Sms;

use Hyperf\Contract\ConfigInterface;
use InvalidArgumentException;
use function Hyperf\Support\make;

class SmsFactory
{
    public function __construct(private ConfigInterface $config)
    {
    }

    public function make(string $driver)
    {
        $option = $this->config->get('sms.driver.' . $driver, []);

        if (empty($option)) {
            throw new InvalidArgumentException("短信配置文件缺少[{$driver}]驱动!");
        }

        return make($option['driver'], [
            'config' => $option['config'],
            'driver' => $driver,
            'name'   => $option['name']
        ]);
    }
}