<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Group;

class GroupMemberItem
{
    /**
     * @param string|int $memberAccount 待导入的群成员帐号
     * @param string $role 待导入群成员角色；目前只支持填 Admin，不填则为普通成员 Member
     * @param int $joinTime 待导入群成员的入群时间
     * @param int $unreadMsgNum 待导入群成员的未读消息计数
     */
    public function __construct(public string|int $memberAccount,
                                public string $role = '',
                                public int $joinTime = 0,
                                public int $unreadMsgNum = 0)
    {
    }

    /**
     * @return array
     */
    public function output(): array
    {
        return [
            'Member_Account' => (string)$this->memberAccount,
            'Role'           => $this->role,
            'JoinTime'       => $this->joinTime,
            'UnreadMsgNum'   => $this->unreadMsgNum,
        ];
    }
}