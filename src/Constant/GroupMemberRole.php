<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Constant;

class GroupMemberRole
{
    /**
     * 群主
     */
    const OWNER = 'Owner';

    /**
     * 群管理员
     */
    const ADMIN = 'Admin';

    /**
     * 普通群成员
     */
    const MEMBER = 'Member';

    /**
     * 非群成员
     */
    const NOT_MEMBER = 'NotMember';
}