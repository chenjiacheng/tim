<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Group;

use Chenjiacheng\Tim\Traits\TIMMsgTrait;

class GroupMsgItem
{
    use TIMMsgTrait;

    /**
     * @param string|int $fromAccount 指定消息发送者
     * @param int $sendTime 消息发送时间
     * @param int $random 32位无符号整数；如果5分钟内两条消息的随机值相同，后一条消息将被当做重复消息而丢弃
     */
    public function __construct(public string|int $fromAccount,
                                public int $sendTime,
                                public int $random = 0)
    {
    }

    /**
     * @return array
     */
    public function output(): array
    {
        return [
            'From_Account' => (string)$this->fromAccount,
            'SendTime'     => $this->sendTime,
            'Random'       => $this->random,
            'MsgBody'      => $this->msgBody,
        ];
    }

    /**
     * @return int|string
     */
    public function getFromAccount(): int|string
    {
        return $this->fromAccount;
    }

    /**
     * @param int|string $fromAccount
     *
     * @return GroupMsgItem
     */
    public function setFromAccount(int|string $fromAccount): GroupMsgItem
    {
        $this->fromAccount = $fromAccount;
        return $this;
    }

    /**
     * @return int
     */
    public function getSendTime(): int
    {
        return $this->sendTime;
    }

    /**
     * @param int $sendTime
     *
     * @return GroupMsgItem
     */
    public function setSendTime(int $sendTime): GroupMsgItem
    {
        $this->sendTime = $sendTime;
        return $this;
    }

    /**
     * @return int
     */
    public function getRandom(): int
    {
        return $this->random;
    }

    /**
     * @param int $random
     *
     * @return GroupMsgItem
     */
    public function setRandom(int $random): GroupMsgItem
    {
        $this->random = $random;
        return $this;
    }
}