<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Provider;

use Chenjiacheng\Tim\Service\Openim;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class OpenimServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['openim'] ?? $pimple['openim'] = function ($pimple) {
            return new Openim($pimple);
        };
    }
}