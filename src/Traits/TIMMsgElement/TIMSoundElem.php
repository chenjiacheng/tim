<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Traits\TIMMsgElement;

use Chenjiacheng\Tim\Contract\TIMMsgInterface;
use JetBrains\PhpStorm\ArrayShape;

class TIMSoundElem implements TIMMsgInterface
{
    protected string $url;
    protected string $uuid;
    protected int $size;
    protected int $second;
    protected int $downloadFlag;

    public function __construct(string $url, string $uuid, int $size, int $second, int $downloadFlag)
    {
        $this->url = $url;
        $this->uuid = $uuid;
        $this->size = $size;
        $this->second = $second;
        $this->downloadFlag = $downloadFlag;
    }

    #[ArrayShape(['MsgType' => "string", 'MsgContent' => "array"])]
    public function output(): array
    {
        return [
            'MsgType'    => 'TIMSoundElem',
            'MsgContent' => [
                'Url'           => $this->url,
                'UUID'          => $this->uuid,
                'Size'          => $this->size,
                'Second'        => $this->second,
                'Download_Flag' => $this->downloadFlag,
            ]
        ];
    }
}