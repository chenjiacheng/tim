<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Traits\TIMMsgElement;

use Chenjiacheng\Tim\Contract\TIMMsgInterface;
use JetBrains\PhpStorm\ArrayShape;

class TIMCustomElem implements TIMMsgInterface
{
    protected string $data;
    protected string $desc;
    protected string $ext;
    protected string $sound;

    public function __construct(string $data, string $desc, string $ext, string $sound)
    {
        $this->data = $data;
        $this->desc = $desc;
        $this->ext = $ext;
        $this->sound = $sound;
    }

    #[ArrayShape(['MsgType' => "string", 'MsgContent' => "array"])]
    public function output(): array
    {
        return [
            'MsgType'    => 'TIMCustomElem',
            'MsgContent' => [
                'Data'  => $this->data,
                'Desc'  => $this->desc,
                'Ext'   => $this->ext,
                'Sound' => $this->sound,
            ]
        ];
    }
}