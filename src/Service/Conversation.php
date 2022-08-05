<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Exception\InvalidConfigException;
use Chenjiacheng\Tim\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;

class Conversation extends AbstractService
{
    /**
     * 拉取会话列表
     *
     * @see https://cloud.tencent.com/document/product/269/62118
     *
     * @param string|int $fromUserId
     * @param int $timeStamp
     * @param int $startIndex
     * @param int $topTimeStamp
     * @param int $topStartIndex
     * @param int $assistFlags
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getList(string|int $fromUserId, int $timeStamp = 0, int $startIndex = 0,
                            int $topTimeStamp = 0, int $topStartIndex = 0, int $assistFlags = 0): Collection
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
     * @param string|int $fromUserId
     * @param string|int $toUserId
     * @param bool $clearRamble
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
                'From_Account' => (string)$fromUserId,
                'Type'         => 1,
                'To_Account'   => (string)$toUserId,
                'ClearRamble'  => $clearRamble ? 1 : 0,
            ]);
    }

    /**
     * 删除单个G2C会话
     *
     * @see https://cloud.tencent.com/document/product/269/62119
     *
     * @param string|int $fromUserId
     * @param string $toGroupId
     * @param bool $clearRamble
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
                'From_Account' => (string)$fromUserId,
                'Type'         => 2,
                'ToGroupid'    => $toGroupId,
                'ClearRamble'  => $clearRamble ? 1 : 0,
            ]);
    }
}