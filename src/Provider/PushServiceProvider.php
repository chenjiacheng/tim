<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Provider;

use Chenjiacheng\Tim\Service\Push;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class PushServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['push'] ?? $pimple['push'] = function ($pimple) {
            return new Push($pimple);
        };
    }
}