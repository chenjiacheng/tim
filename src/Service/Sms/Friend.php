<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Sms;

use Chenjiacheng\Tim\Constant\FriendAddType;
use Chenjiacheng\Tim\Constant\FriendCheckType;
use Chenjiacheng\Tim\Constant\FriendDeleteType;
use Chenjiacheng\Tim\Exception\InvalidArgumentException;
use Chenjiacheng\Tim\Exception\InvalidConfigException;
use Chenjiacheng\Tim\Service\AbstractService;
use Chenjiacheng\Tim\Support\Arr;
use Chenjiacheng\Tim\Support\Collection;
use Chenjiacheng\Tim\Tim;
use GuzzleHttp\Exception\GuzzleException;

class Friend extends AbstractService
{
    /**
     * Friend constructor.
     *
     * @param Tim $app
     * @param string $fromAccount
     */
    public function __construct(protected Tim $app, protected string $fromAccount)
    {
        parent::__construct($this->app);
    }

    /**
     * 添加好友
     *
     * @see https://cloud.tencent.com/document/product/269/1643
     *
     * @param array $addFriendItem 好友结构体对象
     * @param string $addType 加好友方式（默认双向加好友方式）：单向加好友=FriendAddType::SINGLE，双向加好友=FriendAddType::BOTH
     * @param bool $forceAddFlags 是否管理员强制加好友标记
     *
     * @return Collection
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function add(array $addFriendItem, string $addType = '', bool $forceAddFlags = false): Collection
    {
        if (!empty($addType) && !in_array($addType, [FriendAddType::SINGLE, FriendAddType::BOTH])) {
            throw new InvalidArgumentException(sprintf('Unsupported add type "%s"', $addType));
        }

        return $this->httpPostJson(
            'v4/sns/friend_add',
            array_merge([
                'From_Account'  => $this->fromAccount,
                'AddFriendItem' => $addFriendItem,
            ], array_filter([
                'AddType'       => $addType,
                'ForceAddFlags' => $forceAddFlags ? 1 : 0,
            ])));
    }

    /**
     * 导入好友
     *
     * @see https://cloud.tencent.com/document/product/269/8301
     *
     * @param array $addFriendItem 好友结构体对象
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function import(array $addFriendItem): Collection
    {
        return $this->httpPostJson(
            'v4/sns/friend_import',
            [
                'From_Account'  => $this->fromAccount,
                'AddFriendItem' => $addFriendItem,
            ]);
    }

    /**
     * 更新好友
     *
     * @see https://cloud.tencent.com/document/product/269/12525
     *
     * @param array $updateItem 需要更新的好友对象数组
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function update(array $updateItem): Collection
    {
        return $this->httpPostJson(
            'v4/sns/friend_update',
            [
                'From_Account' => $this->fromAccount,
                'UpdateItem'   => $updateItem,
            ]);
    }

    /**
     * 删除好友
     *
     * @see https://cloud.tencent.com/document/product/269/1644
     *
     * @param array|string|int $toAccount 待删除的好友的 UserID 列表，单次请求的 To_Account 数不得超过1000
     * @param string $deleteType 删除模式：单向删除好友=FriendDeleteType::SINGLE，双向删除好友=FriendDeleteType::BOTH
     *
     * @return Collection
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function delete(array|string|int $toAccount, string $deleteType = FriendDeleteType::BOTH): Collection
    {
        if (!empty($deleteType) && !in_array($deleteType, [FriendDeleteType::SINGLE, FriendDeleteType::BOTH])) {
            throw new InvalidArgumentException(sprintf('Unsupported delete type "%s"', $deleteType));
        }

        return $this->httpPostJson(
            'v4/sns/friend_delete',
            [
                'From_Account' => $this->fromAccount,
                'To_Account'   => array_map('strval', Arr::wrap($toAccount)),
                'DeleteType'   => $deleteType,
            ]);
    }

    /**
     * 删除所有好友
     *
     * @see https://cloud.tencent.com/document/product/269/1645
     *
     * @param string $deleteType 删除模式：单向删除好友=FriendDeleteType::SINGLE，双向删除好友=FriendDeleteType::BOTH
     *
     * @return Collection
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function deleteAll(string $deleteType = FriendDeleteType::BOTH): Collection
    {
        if (!empty($deleteType) && !in_array($deleteType, [FriendDeleteType::SINGLE, FriendDeleteType::BOTH])) {
            throw new InvalidArgumentException(sprintf('Unsupported delete type "%s"', $deleteType));
        }

        return $this->httpPostJson(
            'v4/sns/friend_delete_all',
            [
                'From_Account' => $this->fromAccount,
                'DeleteType'   => $deleteType,
            ]);
    }

    /**
     * 校验好友
     *
     * @see https://cloud.tencent.com/document/product/269/1646
     *
     * @param array|string|int $toAccount 请求校验的好友的 UserID 列表，单次请求的 To_Account 数不得超过1000
     * @param string $checkType 校验模式：单向校验好友关系=FriendCheckType::CheckResult_Type_Single，双向校验好友关系=FriendCheckType::CheckResult_Type_Both
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function check(array|string|int $toAccount, string $checkType = FriendCheckType::BOTH): Collection
    {
        return $this->httpPostJson(
            'v4/sns/friend_check',
            [
                'From_Account' => $this->fromAccount,
                'To_Account'   => array_map('strval', Arr::wrap($toAccount)),
                'CheckType'    => $checkType,
            ]);
    }

    /**
     * 拉取好友
     *
     * @see https://cloud.tencent.com/document/product/269/1647
     *
     * @param int $startIndex 分页的起始位置
     * @param int $standardSequence 上次拉好友数据时返回的 StandardSequence，如果 StandardSequence 字段的值与后台一致，后台不会返回标配好友数据
     * @param int $customSequence 上次拉好友数据时返回的 CustomSequence，如果 CustomSequence 字段的值与后台一致，后台不会返回自定义好友数据
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function get(int $startIndex = 0, int $standardSequence = 0, int $customSequence = 0): Collection
    {
        return $this->httpPostJson(
            'v4/sns/friend_get',
            array_merge([
                'From_Account' => $this->fromAccount,
                'StartIndex'   => $startIndex,
            ], array_filter([
                'StandardSequence' => $standardSequence,
                'CustomSequence'   => $customSequence,
            ])));
    }

    /**
     * 拉取指定好友
     *
     * @see https://cloud.tencent.com/document/product/269/8609
     *
     * @param array|string|int $toAccount 好友的 UserID 列表，建议每次请求的好友数不超过100，避免因数据量太大导致回包失败
     * @param array $tagList 指定要拉取的资料字段及好友字段
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getList(array|string|int $toAccount, array $tagList): Collection
    {
        return $this->httpPostJson(
            'v4/sns/friend_get_list',
            [
                'From_Account' => $this->fromAccount,
                'To_Account'   => array_map('strval', Arr::wrap($toAccount)),
                'TagList'      => $tagList,
            ]);
    }
}