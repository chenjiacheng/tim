<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Constant;

/**
 * 管理员禁止加好友标识
 */
class ProfileAdminForbidType
{
    /**
     * 允许加好友
     */
    const NONE = 'AdminForbid_Type_None';

    /**
     * 禁止该用户发起加好友请求
     */
    const SEND_OUT = 'AdminForbid_Type_SendOut';
}