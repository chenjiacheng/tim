<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Provider;

use Chenjiacheng\Tim\Service\Sms;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class SmsServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['sms'] ?? $pimple['sms'] = function ($pimple) {
            return new Sms($pimple);
        };
    }
}