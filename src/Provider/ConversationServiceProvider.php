<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Provider;

use Chenjiacheng\Tim\Service\Conversation;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConversationServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['conversation'] ?? $pimple['conversation'] = function ($pimple) {
            return new Conversation($pimple);
        };
    }
}