<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Provider;

use Chenjiacheng\Tim\Service\Message;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class MessageServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['message'] ?? $pimple['message'] = function ($pimple) {
            return new Message($pimple);
        };
    }
}