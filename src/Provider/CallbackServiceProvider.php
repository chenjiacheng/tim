<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Provider;

use Chenjiacheng\Tim\Service\Callback;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class CallbackServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['callback'] ?? $pimple['callback'] = function ($pimple) {
            return new Callback($pimple);
        };
    }
}