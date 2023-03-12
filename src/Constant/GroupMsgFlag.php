<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Constant;

/**
 * 消息屏蔽类型
 */
class GroupMsgFlag
{
    /**
     * 接收并提示消息
     */
    const ACCEPT_AND_NOTIFY = 'AcceptAndNotify';

    /**
     * 不接收也不提示消息
     */
    const DISCARD = 'Discard';

    /**
     * 接收消息但不提示
     */
    const ACCEPT_NOT_NOTIFY = 'AcceptNotNotify';
}