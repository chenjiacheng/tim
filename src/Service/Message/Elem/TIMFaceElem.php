<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Message\Elem;

use Chenjiacheng\Tim\Contract\MessageElemInterface;
use JetBrains\PhpStorm\ArrayShape;

class TIMFaceElem implements MessageElemInterface
{
    protected int $index;
    protected string $data;

    public function __construct(int $index, string $data)
    {
        $this->index = $index;
        $this->data = $data;
    }

    #[ArrayShape(['MsgType' => "string", 'MsgContent' => "array"])]
    public function output(): array
    {
        return [
            'MsgType'    => 'TIMFaceElem',
            'MsgContent' => [
                'Index' => $this->index,
                'Data'  => $this->data,
            ]
        ];
    }
}