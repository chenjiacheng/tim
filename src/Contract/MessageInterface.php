<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Contract;

use Chenjiacheng\Tim\Support\Collection;

interface MessageInterface
{
    /**
     * @param MessageElemInterface $elem
     *
     * @return Collection
     */
    public function sendMsg(MessageElemInterface $elem): Collection;
}