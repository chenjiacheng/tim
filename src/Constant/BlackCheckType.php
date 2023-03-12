<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Constant;

/**
 * 黑名单校验模式
 */
class BlackCheckType
{
    /**
     * 单向校验黑名单关系
     */
    const SINGLE = 'BlackCheckResult_Type_Single';

    /**
     * 双向校验黑名单关系
     */
    const BOTH = 'BlackCheckResult_Type_Both';
}