<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Group;

class GroupMsgList
{
    public array $msgList;

    public function __construct(GroupMsgItem ...$groupMsgItem)
    {
        foreach ($groupMsgItem as $item) {
            $this->msgList[] = array_filter($item->output());
        }
    }

    /**
     * @return array
     */
    public function getMsgList(): array
    {
        return $this->msgList;
    }

    /**
     * @param array $msgList
     */
    public function setMsgList(array $msgList): void
    {
        $this->msgList = $msgList;
    }
}