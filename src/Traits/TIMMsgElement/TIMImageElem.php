<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Traits\TIMMsgElement;

use Chenjiacheng\Tim\Constant\MsgType;
use Chenjiacheng\Tim\Contract\TIMMsgInterface;

class TIMImageElem implements TIMMsgInterface
{
    /**
     * @param string $uuid 图片的唯一标识，客户端用于索引图片的键值
     * @param int $imageFormat 图片格式：JPG = 1，GIF = 2，PNG = 3，BMP = 4，其他 = 255
     * @param array $imageInfoArray 原图、缩略图或者大图下载信息
     */
    public function __construct(public string $uuid, public int $imageFormat, public array $imageInfoArray)
    {
    }

    public function output(): array
    {
        return [
            'MsgType'    => MsgType::TIM_IMAGE_ELEM,
            'MsgContent' => [
                'UUID'           => $this->uuid,
                'ImageFormat'    => $this->imageFormat,
                'ImageInfoArray' => $this->imageInfoArray,
            ]
        ];
    }
}