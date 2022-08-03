<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Contract;

interface MessageElemInterface
{
    /**
     * @return array
     */
    public function output(): array;
}