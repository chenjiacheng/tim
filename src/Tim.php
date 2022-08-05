<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim;

use Chenjiacheng\Tim\Provider\AccountServiceProvider;
use Chenjiacheng\Tim\Provider\ConfigServiceProvider;
use Chenjiacheng\Tim\Provider\ContactServiceProvider;
use Chenjiacheng\Tim\Provider\MessageServiceProvider;
use Chenjiacheng\Tim\Provider\OperateServiceProvider;
use Chenjiacheng\Tim\Provider\ProfileServiceProvider;
use Chenjiacheng\Tim\Provider\PushServiceProvider;
use Chenjiacheng\Tim\Service\Account;
use Chenjiacheng\Tim\Service\Contact;
use Chenjiacheng\Tim\Service\Message;
use Chenjiacheng\Tim\Service\Operate;
use Chenjiacheng\Tim\Service\Profile;
use Chenjiacheng\Tim\Service\Push;
use Pimple\Container;

/**
 * @property array $config
 * @property Account $account
 * @property Contact $contact
 * @property Message $message
 * @property Operate $operate
 * @property Profile $profile
 * @property Push $push
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
        ContactServiceProvider::class,
        MessageServiceProvider::class,
        OperateServiceProvider::class,
        ProfileServiceProvider::class,
        PushServiceProvider::class,
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