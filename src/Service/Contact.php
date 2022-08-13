<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Constant\ChatType;
use Chenjiacheng\Tim\Exception\InvalidArgumentException;
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
     * 删除单个会话
     *
     * @see https://cloud.tencent.com/document/product/269/62119
     *
     * @param string|int $fromUserId 请求删除该 UserID 的会话
     * @param string|int $toId 会话方的 ID
     * @param string $chatType 会话类型：ChatType::C2C 表示 C2C 会话；ChatType::GROUP 表示 G2C 会话
     * @param bool $clearRamble 是否清理漫游消息
     *
     * @return Collection
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function delete(string|int $fromUserId, string|int $toId,
                           string $chatType = ChatType::C2C, bool $clearRamble = true): Collection
    {
        if (!in_array($chatType, [ChatType::C2C, ChatType::GROUP])) {
            throw new InvalidArgumentException(sprintf('Unsupported chat type "%s"', $chatType));
        }
        return $this->httpPostJson(
            'v4/recentcontact/delete',
            $chatType == ChatType::C2C ? [
                'Type'         => 1,
                'From_Account' => (string)$fromUserId,
                'To_Account'   => (string)$toId,
                'ClearRamble'  => $clearRamble ? 1 : 0,
            ] : [
                'Type'         => 2,
                'From_Account' => (string)$fromUserId,
                'ToGroupid'    => (string)$toId,
                'ClearRamble'  => $clearRamble ? 1 : 0,
            ]);
    }
}