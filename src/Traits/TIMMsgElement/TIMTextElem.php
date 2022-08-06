<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Traits\TIMMsgElement;

use Chenjiacheng\Tim\Contract\TIMMsgInterface;
use JetBrains\PhpStorm\ArrayShape;

class TIMTextElem implements TIMMsgInterface
{
    protected string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    #[ArrayShape(['MsgType' => "string", 'MsgContent' => "string[]"])]
    public function output(): array
    {
        return [
            'MsgType'    => 'TIMTextElem',
            'MsgContent' => [
                'Text' => $this->text
            ]
        ];
    }
}