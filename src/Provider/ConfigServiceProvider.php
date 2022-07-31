<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConfigServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['config'] ?? $pimple['config'] = function ($pimple) {
            return $pimple->getConfig();
        };
    }
}