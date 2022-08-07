<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Exception\InvalidConfigException;
use Chenjiacheng\Tim\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;

class Contact extends AbstractService
{
    /**
     * 拉取会话列表
     *
     * @see https://cloud.tencent.com/document/product/269/62118
     *
     * @param string|int $fromUserId 填 UserID，请求拉取该用户的会话列表
     * @param int $timeStamp 普通会话的起始时间，第一页填 0
     * @param int $startIndex 普通会话的起始位置，第一页填 0
     * @param int $topTimeStamp 置顶会话的起始时间，第一页填 0
     * @param int $topStartIndex 置顶会话的起始位置，第一页填 0
     * @param int $assistFlags 会话辅助标志位：bit 0 - 是否支持置顶会话，bit 1 - 是否返回空会话，bit 2 - 是否支持置顶会话分页
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getList(string|int $fromUserId, int $timeStamp = 0, int $startIndex = 0, int $topTimeStamp = 0,
                            int $topStartIndex = 0, int $assistFlags = 0): Collection
    {
        return $this->httpPostJson(
            'v4/recentcontact/get_list',
            [
                'From_Account'  => (string)$fromUserId,
                'TimeStamp'     => $timeStamp,
                'StartIndex'    => $startIndex,
                'TopTimeStamp'  => $topTimeStamp,
                'TopStartIndex' => $topStartIndex,
                'AssistFlags'   => $assistFlags,
            ]);
    }

    /**
     * 删除单个C2C会话
     *
     * @see https://cloud.tencent.com/document/product/269/62119
     *
     * @param string|int $fromUserId 请求删除该 UserID 的会话
     * @param string|int $toUserId 会话方的 UserID
     * @param bool $clearRamble 是否清理漫游消息
     *
     * @return \Chenjiacheng\Tim\Support\Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function deleteC2C(string|int $fromUserId, string|int $toUserId, bool $clearRamble = true): Collection
    {
        return $this->httpPostJson(
            'v4/recentcontact/delete',
            [
                'Type'         => 1,
                'From_Account' => (string)$fromUserId,
                'To_Account'   => (string)$toUserId,
                'ClearRamble'  => $clearRamble ? 1 : 0,
            ]);
    }

    /**
     * 删除单个G2C会话
     *
     * @see https://cloud.tencent.com/document/product/269/62119
     *
     * @param string|int $fromUserId 请求删除该 UserID 的会话
     * @param string $toGroupId 会话的群 ID
     * @param bool $clearRamble 是否清理漫游消息
     *
     * @return \Chenjiacheng\Tim\Support\Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function deleteG2C(string|int $fromUserId, string $toGroupId, bool $clearRamble = true): Collection
    {
        return $this->httpPostJson(
            'v4/recentcontact/delete',
            [
                'Type'         => 2,
                'From_Account' => (string)$fromUserId,
                'ToGroupid'    => $toGroupId,
                'ClearRamble'  => $clearRamble ? 1 : 0,
            ]);
    }
}