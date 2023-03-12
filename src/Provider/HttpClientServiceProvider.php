<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Provider;

use GuzzleHttp\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class HttpClientServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['httpClient'] ?? $pimple['httpClient'] = function ($pimple) {
            return new Client($pimple->config->get('http', []));
        };
    }
}