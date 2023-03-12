<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Traits\TIMMsgElement;

use Chenjiacheng\Tim\Constant\MsgType;
use Chenjiacheng\Tim\Contract\TIMMsgInterface;

class TIMCustomElem implements TIMMsgInterface
{
    /**
     * @param string $data 自定义消息数据
     * @param string $desc 自定义消息描述信息
     * @param string $ext 扩展字段
     * @param string $sound 自定义 APNs 推送铃音
     */
    public function __construct(public string $data, public string $desc, public string $ext, public string $sound)
    {
    }

    public function output(): array
    {
        return [
            'MsgType'    => MsgType::TIM_CUSTOM_ELEM,
            'MsgContent' => [
                'Data'  => $this->data,
                'Desc'  => $this->desc,
                'Ext'   => $this->ext,
                'Sound' => $this->sound,
            ]
        ];
    }
}