<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Exception\InvalidConfigException;
use Chenjiacheng\Tim\Support\Arr;
use Chenjiacheng\Tim\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;

class Account extends BaseService
{
    /**
     * 导入单个帐号
     *
     * @see https://cloud.tencent.com/document/product/269/1608
     *
     * @param string|int $identifier 用户名，长度不超过32字节
     * @param string $nick 用户昵称
     * @param string $faceUrl 用户头像 URL
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function import(string|int $identifier, string $nick = '', string $faceUrl = ''): Collection
    {
        return $this->httpPostJson(
            'v4/im_open_login_svc/account_import',
            [
                'Identifier' => (string)$identifier,
                'Nick'       => $nick,
                'FaceUrl'    => $faceUrl,
            ]);
    }

    /**
     * 导入多个帐号
     *
     * @see https://cloud.tencent.com/document/product/269/4919
     *
     * @param array $accounts 用户名，单个用户名长度不超过32字节，单次最多导入100个用户名
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function multiImport(array $accounts): Collection
    {
        return $this->httpPostJson(
            'v4/im_open_login_svc/multiaccount_import',
            [
                'Accounts' => array_map('strval', $accounts),
            ]);
    }

    /**
     * 删除帐号
     *
     * @see https://cloud.tencent.com/document/product/269/36443
     *
     * @param array|string|int $accounts 请求删除的 UserID 数组，单次请求最多支持100个帐号
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function delete(array|string|int $accounts): Collection
    {
        $deleteItem = [];
        foreach (Arr::wrap($accounts) as $account) {
            $deleteItem[] = ['UserID' => (string)$account];
        }

        return $this->httpPostJson(
            'v4/im_open_login_svc/account_delete',
            [
                'DeleteItem' => $deleteItem,
            ]);
    }

    /**
     * 查询帐号
     *
     * @see https://cloud.tencent.com/document/product/269/38417
     *
     * @param array|string|int $accounts 请求删除的 UserID 数组，单次请求最多支持100个帐号
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function check(array|string|int $accounts): Collection
    {
        $checkItem = [];
        foreach (Arr::wrap($accounts) as $account) {
            $checkItem[] = ['UserID' => (string)$account];
        }

        return $this->httpPostJson(
            'v4/im_open_login_svc/account_check',
            [
                'CheckItem' => $checkItem
            ]
        );
    }

    /**
     * 失效帐号登录态
     *
     * @see https://cloud.tencent.com/document/product/269/3853
     *
     * @param string|int $account 用户名
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function kick(string|int $account): Collection
    {
        return $this->httpPostJson(
            'v4/im_open_login_svc/kick',
            [
                'UserID' => (string)$account,
            ]
        );
    }

    /**
     * 查询帐号在线状态
     *
     * @see https://cloud.tencent.com/document/product/269/2566
     *
     * @param array|string|int $toAccount 需要查询这些 UserID 的登录状态，一次最多查询500个 UserID 的状态
     * @param int $isNeedDetail 是否需要返回详细的登录平台信息。0表示不需要，1表示需要
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function queryStatus(array|string|int $toAccount, int $isNeedDetail = 0): Collection
    {
        return $this->httpPostJson(
            'v4/openim/query_online_status',
            [
                'To_Account'   => array_map('strval', Arr::wrap($toAccount)),
                'IsNeedDetail' => $isNeedDetail,
            ]
        );
    }
}