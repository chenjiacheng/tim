<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Sms;

use Chenjiacheng\Tim\Exception\InvalidConfigException;
use Chenjiacheng\Tim\Service\AbstractService;
use Chenjiacheng\Tim\Support\Arr;
use Chenjiacheng\Tim\Support\Collection;
use Chenjiacheng\Tim\Tim;
use GuzzleHttp\Exception\GuzzleException;

class Group extends AbstractService
{
    /**
     * @param Tim $app
     * @param string $fromAccount
     */
    public function __construct(protected Tim $app, protected string $fromAccount)
    {
        parent::__construct($this->app);
    }

    /**
     * 添加分组
     *
     * @see https://cloud.tencent.com/document/product/269/10107
     *
     * @param array|string $groupName 新增分组列表
     * @param array|string|int|null $toAccount 需要加入新增分组的好友的 UserID 列表
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function add(array|string $groupName, array|string|int $toAccount = null): Collection
    {
        return $this->httpPostJson(
            'v4/sns/group_add',
            array_merge([
                'From_Account' => $this->fromAccount,
                'GroupName'    => Arr::wrap($groupName),
            ], array_filter([
                'To_Account' => array_map('strval', Arr::wrap($toAccount)),
            ])));
    }

    /**
     * 删除分组
     *
     * @see https://cloud.tencent.com/document/product/269/10108
     *
     * @param array|string $groupName 要删除的分组列表
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function delete(array|string $groupName): Collection
    {
        return $this->httpPostJson('v4/sns/group_delete', [
            'From_Account' => $this->fromAccount,
            'GroupName'    => Arr::wrap($groupName),
        ]);
    }

    /**
     * 拉取分组
     *
     * @see https://cloud.tencent.com/document/product/269/54763
     *
     * @param array|string $groupName 要拉取的分组名称
     * @param bool $needFriend 是否需要拉取分组下的 User 列表
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function get(array|string $groupName = [], bool $needFriend = false): Collection
    {
        return $this->httpPostJson(
            'v4/sns/group_get',
            array_merge([
                'From_Account' => $this->fromAccount,
            ], array_filter([
                'GroupName'  => Arr::wrap($groupName),
                'NeedFriend' => $needFriend ? 'Need_Friend_Type_Yes' : '',
            ])));
    }
}