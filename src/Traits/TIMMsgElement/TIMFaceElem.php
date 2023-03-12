<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Traits\TIMMsgElement;

use Chenjiacheng\Tim\Constant\MsgType;
use Chenjiacheng\Tim\Contract\TIMMsgInterface;

class TIMFaceElem implements TIMMsgInterface
{
    /**
     * @param int $index 表情索引，用户自定义
     * @param string $data 额外数据
     */
    public function __construct(public int $index, public string $data)
    {
    }

    public function output(): array
    {
        return [
            'MsgType'    => MsgType::TIM_FACE_ELEM,
            'MsgContent' => [
                'Index' => $this->index,
                'Data'  => $this->data,
            ]
        ];
    }
}