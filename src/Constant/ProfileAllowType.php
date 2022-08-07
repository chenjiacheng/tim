<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Constant;

/**
 * 加好友验证方式
 */
class ProfileAllowType
{
    /**
     * 需要经过自己确认对方才能添加自己为好友
     */
    const NEED_CONFIRM = 'AllowType_Type_NeedConfirm';

    /**
     * 允许任何人添加自己为好友
     */
    const ALLOW_ANY = 'AllowType_Type_AllowAny';

    /**
     * 不允许任何人添加自己为好友
     */
    const DENY_ANY = 'AllowType_Type_DenyAny';
}