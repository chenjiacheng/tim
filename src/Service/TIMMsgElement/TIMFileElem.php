<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\TIMMsgElement;

use Chenjiacheng\Tim\Contract\TIMMsgInterface;
use JetBrains\PhpStorm\ArrayShape;

class TIMFileElem implements TIMMsgInterface
{
    protected string $url;
    protected string $uuid;

    public function __construct(string $url, string $uuid)
    {
        $this->url = $url;
        $this->uuid = $uuid;
    }

    #[ArrayShape(['MsgType' => "string", 'MsgContent' => "array"])]
    public function output(): array
    {
        return [
            'MsgType'    => 'TIMFileElem',
            'MsgContent' => [
                'Url'           => $this->url,
                'UUID'          => $this->uuid,
                'FileSize'      => filesize($this->url),
                'FileName'      => basename($this->url),
                'Download_Flag' => 2,
            ]
        ];
    }
}