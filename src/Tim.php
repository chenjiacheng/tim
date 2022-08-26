<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim;

use Chenjiacheng\Tim\Provider\AccountServiceProvider;
use Chenjiacheng\Tim\Provider\ConfigServiceProvider;
use Chenjiacheng\Tim\Provider\ContactServiceProvider;
use Chenjiacheng\Tim\Provider\GroupServiceProvider;
use Chenjiacheng\Tim\Provider\HttpClientServiceProvider;
use Chenjiacheng\Tim\Provider\MessageServiceProvider;
use Chenjiacheng\Tim\Provider\OperateServiceProvider;
use Chenjiacheng\Tim\Provider\OverallServiceProvider;
use Chenjiacheng\Tim\Provider\ProfileServiceProvider;
use Chenjiacheng\Tim\Provider\PushServiceProvider;
use Chenjiacheng\Tim\Provider\SnsServiceProvider;
use Chenjiacheng\Tim\Service\Account;
use Chenjiacheng\Tim\Service\Contact;
use Chenjiacheng\Tim\Service\Group;
use Chenjiacheng\Tim\Service\Message;
use Chenjiacheng\Tim\Service\Operate;
use Chenjiacheng\Tim\Service\Overall;
use Chenjiacheng\Tim\Service\Profile;
use Chenjiacheng\Tim\Service\Push;
use Chenjiacheng\Tim\Service\Sns;
use Chenjiacheng\Tim\Support\Config;
use GuzzleHttp\Client;
use Pimple\Container;

/**
 * @property Account $account
 * @property Contact $contact
 * @property Group $group
 * @property Message $message
 * @property Operate $operate
 * @property Overall $overall
 * @property Profile $profile
 * @property Push $push
 * @property Sns $sns
 * @property Config $config
 * @property Client $httpClient
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
        GroupServiceProvider::class,
        MessageServiceProvider::class,
        OperateServiceProvider::class,
        OverallServiceProvider::class,
        ProfileServiceProvider::class,
        PushServiceProvider::class,
        SnsServiceProvider::class,
    ];

    /**
     * @var array
     */
    protected array $config;

    /**
     * Tim constructor.
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
            HttpClientServiceProvider::class,
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