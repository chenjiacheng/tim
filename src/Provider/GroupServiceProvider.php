<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Provider;

use Chenjiacheng\Tim\Service\Group;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class GroupServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['group'] ?? $pimple['group'] = function ($pimple) {
            return new Group($pimple);
        };
    }
}