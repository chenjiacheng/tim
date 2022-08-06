<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Service\Sms\Black;
use Chenjiacheng\Tim\Service\Sms\Friend;
use Chenjiacheng\Tim\Service\Sms\Group;
use JetBrains\PhpStorm\Pure;

class Sms extends AbstractService
{
    /**
     * @param string|int $fromAccount
     *
     * @return Black
     */
    #[Pure] public function black(string|int $fromAccount): Black
    {
        return new Black($this->app, $fromAccount);
    }

    /**
     * @param string|int $fromAccount
     *
     * @return Friend
     */
    #[Pure] public function friend(string|int $fromAccount): Friend
    {
        return new Friend($this->app, $fromAccount);
    }

    /**
     * @param string|int $fromAccount
     *
     * @return Group
     */
    #[Pure] public function group(string|int $fromAccount): Group
    {
        return new Group($this->app, $fromAccount);
    }


}