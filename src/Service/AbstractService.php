<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Exception\InvalidConfigException;
use Chenjiacheng\Tim\Support\Collection;
use Chenjiacheng\Tim\Tim;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

abstract class AbstractService
{
    /**
     * @param Tim $app
     */
    public function __construct(protected Tim $app)
    {
    }

    /**
     * @param string $uri
     * @param array $data
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    protected function httpPostJson(string $uri, array $data = []): Collection
    {
        $uri .= '?';
        $uri .= http_build_query([
            'sdkappid'    => $this->app->config->get('sdkappid'),
            'identifier'  => $this->app->config->get('identifier'),
            'usersig'     => $this->genUserSig($this->app->config->get('identifier')),
            'random'      => $this->getRandom(),
            'contenttype' => 'json',
        ]);

        $options = [
            'json'    => $data,
            'headers' => [
                'content-type' => 'application/json;charset=utf-8'
            ]
        ];

        $httpClient = new Client($this->app->config->get('http'));

        $response = $httpClient->post($uri, $options);
        $contents = $response->getBody()->getContents();

        return new Collection(json_decode($contents, true));
    }

    /**
     * @param string $identifier
     * @param int $expire
     *
     * @return string
     *
     * @throws InvalidConfigException
     */
    protected function genUserSig(string $identifier, int $expire = 86400 * 180): string
    {
        $currTime = time();

        $contentToBeSigned = 'TLS.identifier:' . $identifier . "\n"
            . 'TLS.sdkappid:' . $this->app->config->get('sdkappid') . "\n"
            . 'TLS.time:' . $currTime . "\n"
            . 'TLS.expire:' . $expire . "\n";

        $sigArray = [
            'TLS.ver'        => '2.0',
            'TLS.identifier' => $identifier,
            'TLS.sdkappid'   => intval($this->app->config->get('sdkappid')),
            'TLS.expire'     => $expire,
            'TLS.time'       => $currTime,
            'TLS.sig'        => base64_encode(hash_hmac('sha256', $contentToBeSigned, $this->app->config->get('key'), true))
        ];

        $jsonStrSig = json_encode($sigArray);
        if ($jsonStrSig === false) {
            throw new InvalidConfigException('Signature JSON format error');
        }

        $compressed = gzcompress($jsonStrSig);
        if ($compressed === false) {
            throw new InvalidConfigException('Signature string compression error');
        }

        $replace = ['+' => '*', '/' => '-', '=' => '_'];

        return str_replace(array_keys($replace), array_values($replace), base64_encode($compressed));
    }

    /**
     * 获取随机UUID
     *
     * @return string
     */
    public function getUUID(): string
    {
        return (microtime(true) * 1000) . '_' . rand(100000000, 999999999);
    }

    /**
     * @return int
     */
    public function getRandom(): int
    {
        return rand(0, 4294967295);
    }
}