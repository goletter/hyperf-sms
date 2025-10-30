<?php

declare(strict_types=1);

namespace Goletter\Sms\Facade;

use Hyperf\Context\ApplicationContext;
use Goletter\Sms\Contract\SmsInterface;
use Goletter\Sms\SmsFactory;

/**
 * @method static SmsInterface make(string $driver)
 */
class Sms
{
    public static function __callStatic($name, $arguments)
    {
        return self::driver(...$arguments);
    }

    public static function driver(string $driver): SmsInterface
    {
        /**
         * @var SmsFactory $factory
         */
        $factory = ApplicationContext::getContainer()->get(SmsFactory::class);

        return $factory->make($driver);
    }
}