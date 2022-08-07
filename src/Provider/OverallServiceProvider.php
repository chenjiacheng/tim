<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Provider;

use Chenjiacheng\Tim\Service\Overall;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class OverallServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['overall'] ?? $pimple['overall'] = function ($pimple) {
            return new Overall($pimple);
        };
    }
}