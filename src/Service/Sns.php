<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Service\Sns\Black;
use Chenjiacheng\Tim\Service\Sns\Friend;
use Chenjiacheng\Tim\Service\Sns\Group;

class Sns extends AbstractService
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