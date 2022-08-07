<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Service\Sms\Black;
use Chenjiacheng\Tim\Service\Sms\Friend;
use Chenjiacheng\Tim\Service\Sms\Group;

class Sms extends AbstractService
{
    /**
     * 黑名单管理
     *
     * @param string|int $fromAccount 操作的 UserID
     *
     * @return Black
     */
    public function black(string|int $fromAccount): Black
    {
        return new Black($this->app, (string)$fromAccount);
    }

    /**
     * 好友管理
     *
     * @param string|int $fromAccount
     *
     * @return Friend
     */
    public function friend(string|int $fromAccount): Friend
    {
        return new Friend($this->app, (string)$fromAccount);
    }

    /**
     * 分组管理
     *
     * @param string|int $fromAccount
     *
     * @return Group
     */
    public function group(string|int $fromAccount): Group
    {
        return new Group($this->app, (string)$fromAccount);
    }
}