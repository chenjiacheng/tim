<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Constant;

/**
 * 申请加群处理方式
 *
 * Class GroupApplyJoinOption
 * @package Chenjiacheng\Tim\Constant
 */
class GroupApplyJoinOption
{
    /**
     * 自由加入
     */
    const FREE_ACCESS = 'FreeAccess';

    /**
     * 需要验证
     */
    const NEED_PERMISSION = 'NeedPermission';

    /**
     * 禁止加群
     */
    const DISABLE_APPLY = 'DisableApply';
}