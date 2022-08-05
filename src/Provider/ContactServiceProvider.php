<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Provider;

use Chenjiacheng\Tim\Service\Contact;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ContactServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['contact'] ?? $pimple['contact'] = function ($pimple) {
            return new Contact($pimple);
        };
    }
}