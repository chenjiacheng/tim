<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Provider;

use Chenjiacheng\Tim\Service\Profile;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ProfileServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['profile'] ?? $pimple['profile'] = function ($pimple) {
            return new Profile($pimple);
        };
    }
}