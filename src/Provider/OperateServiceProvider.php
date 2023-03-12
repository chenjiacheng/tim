<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Provider;

use Chenjiacheng\Tim\Service\Operate;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class OperateServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['operate'] ?? $pimple['operate'] = function ($pimple) {
            return new Operate($pimple);
        };
    }
}