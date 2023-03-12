<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Provider;

use Chenjiacheng\Tim\Service\Sns;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class SnsServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['sns'] ?? $pimple['sns'] = function ($pimple) {
            return new Sns($pimple);
        };
    }
}