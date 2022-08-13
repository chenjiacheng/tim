<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Group;

class GroupMemberList
{
    public array $memberList;

    public function __construct(GroupMemberItem ...$groupMemberItem)
    {
        foreach ($groupMemberItem as $item) {
            $this->memberList[] = array_filter($item->output());
        }
    }

    /**
     * @return array
     */
    public function getMemberList(): array
    {
        return $this->memberList;
    }

    /**
     * @param array $memberList
     */
    public function setMemberList(array $memberList): void
    {
        $this->memberList = $memberList;
    }
}