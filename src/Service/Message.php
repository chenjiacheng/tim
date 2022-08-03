<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Service\Message\Account;

class Message extends AbstractService
{
    /**
     * @param array|string|int $toAccount 消息接收方 UserID
     * @return Account
     */
    public function toAccount(array|string|int $toAccount): Account
    {
        return new Account($this->app, $toAccount);
    }
}