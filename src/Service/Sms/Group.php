<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Sms;

use Chenjiacheng\Tim\Exception\InvalidConfigException;
use Chenjiacheng\Tim\Service\AbstractService;
use Chenjiacheng\Tim\Support\Arr;
use Chenjiacheng\Tim\Support\Collection;
use Chenjiacheng\Tim\Tim;
use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\Pure;

class Group extends AbstractService
{
    /**
     * @var string
     */
    protected string $fromAccount;

    /**
     * Group constructor.
     * @param Tim $app
     * @param string|int $fromAccount
     */
    #[Pure] public function __construct(Tim $app, string|int $fromAccount)
    {
        parent::__construct($app);

        $this->fromAccount = (string)$fromAccount;
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
        $data = [
            'From_Account' => $this->fromAccount,
            'GroupName'    => Arr::wrap($groupName),
        ];

        isset($toAccount) && $data['To_Account'] = array_map('strval', Arr::wrap($toAccount));

        return $this->httpPostJson('v4/sns/group_add', $data);
    }

    /**
     * 拉取分组
     *
     * @see https://cloud.tencent.com/document/product/269/54763
     *
     * @param bool $needFriend 是否需要拉取分组下的 User 列表
     * @param array|string|null $groupName 要拉取的分组名称
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function get(bool $needFriend = false, array|string $groupName = null): Collection
    {
        $data = [
            'From_Account' => $this->fromAccount,
        ];

        isset($needFriend) && $data['NeedFriend'] = 'Need_Friend_Type_Yes';
        isset($groupName) && $data['GroupName'] = Arr::wrap($groupName);

        return $this->httpPostJson('v4/sns/group_get', $data);
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
}