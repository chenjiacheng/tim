<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Exception\InvalidConfigException;
use Chenjiacheng\Tim\Support\Collection;
use Chenjiacheng\Tim\Tim;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

abstract class BaseService
{
    protected Tim $app;

    /**
     * @param Tim $app
     */
    public function __construct(Tim $app)
    {
        $this->app = $app;
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
    protected function httpPostJson(string $uri, array $data): Collection
    {
        $uri .= '?';
        $uri .= http_build_query([
            'sdkappid'    => $this->app->config['sdkappid'],
            'identifier'  => $this->app->config['identifier'],
            'usersig'     => $this->genUserSig($this->app->config['identifier']),
            'random'      => mt_rand(0, 4294967295),
            'contenttype' => 'json',
        ]);

        $options = [
            'json'    => $data,
            'headers' => [
                'content-type' => 'application/json;charset=utf-8'
            ]
        ];

        $httpClient = new Client($this->app->config['http']);

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
            . 'TLS.sdkappid:' . $this->app->config['sdkappid'] . "\n"
            . 'TLS.time:' . $currTime . "\n"
            . 'TLS.expire:' . $expire . "\n";

        $sigArray = [
            'TLS.ver'        => '2.0',
            'TLS.identifier' => $identifier,
            'TLS.sdkappid'   => intval($this->app->config['sdkappid']),
            'TLS.expire'     => $expire,
            'TLS.time'       => $currTime,
            'TLS.sig'        => base64_encode(hash_hmac('sha256', $contentToBeSigned, $this->app->config['key'], true))
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
}