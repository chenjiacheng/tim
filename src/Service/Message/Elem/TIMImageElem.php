<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Message\Elem;

use Chenjiacheng\Tim\Contract\MessageElemInterface;
use JetBrains\PhpStorm\ArrayShape;

class TIMImageElem implements MessageElemInterface
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
        [$width, $height, $suffix] = getimagesize($this->url);
        $imageFormat = match ($suffix) {
            1 => 2,
            2 => 1,
            3 => 3,
            6 => 4,
            default => 255,
        };

        return [
            'MsgType'    => 'TIMImageElem',
            'MsgContent' => [
                'UUID'           => $this->uuid,
                'ImageFormat'    => $imageFormat,
                'ImageInfoArray' => [
                    [
                        'Type'   => 1, // 原图
                        'Size'   => 1,
                        'Width'  => $width,
                        'Height' => $height,
                        'URL'    => $this->url,
                    ]
                ],
            ]
        ];
    }
}