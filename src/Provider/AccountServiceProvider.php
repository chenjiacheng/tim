<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Provider;

use Chenjiacheng\Tim\Service\Account;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AccountServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['account'] ?? $pimple['account'] = function ($pimple) {
            return new Account($pimple);
        };
    }
}