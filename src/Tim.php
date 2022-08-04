<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim;

use Chenjiacheng\Tim\Provider\AccountServiceProvider;
use Chenjiacheng\Tim\Provider\ConfigServiceProvider;
use Chenjiacheng\Tim\Provider\OpenimServiceProvider;
use Chenjiacheng\Tim\Provider\ProfileServiceProvider;
use Chenjiacheng\Tim\Service\Account;
use Chenjiacheng\Tim\Service\Openim;
use Chenjiacheng\Tim\Service\Profile;
use Pimple\Container;

/**
 * @property array $config
 * @property Account $account
 * @property Openim $openim
 * @property Profile $profile
 */
class Tim extends Container
{
    /**
     * Service Providers.
     *
     * @var array|string[]
     */
    protected array $providers = [
        AccountServiceProvider::class,
        OpenimServiceProvider::class,
        ProfileServiceProvider::class,
    ];

    /**
     * @var array
     */
    protected array $config;

    /**
     * Application constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct();

        $this->config = $config;

        $this->registerProviders($this->getProviders());
    }

    /**
     * Return app config.
     *
     * @return array
     */
    public function getConfig(): array
    {
        $base = [
            'http' => [
                'base_uri' => 'https://console.tim.qq.com/',
                'timeout'  => 30.0,
            ],
        ];

        return array_replace_recursive($base, $this->config);
    }

    /**
     * Return all providers.
     *
     * @return array
     */
    public function getProviders(): array
    {
        return array_merge([
            ConfigServiceProvider::class,
        ], $this->providers);
    }

    /**
     * Register providers.
     *
     * @param array $providers
     */
    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }

    /**
     * Magic get access.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function __get(string $id)
    {
        return $this->offsetGet($id);
    }

    /**
     * Magic set access.
     *
     * @param string $id
     * @param mixed $value
     */
    public function __set(string $id, mixed $value)
    {
        $this->offsetSet($id, $value);
    }
}