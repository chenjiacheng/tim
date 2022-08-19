<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Traits\TIMMsgElement;

use Chenjiacheng\Tim\Constant\MsgType;
use Chenjiacheng\Tim\Contract\TIMMsgInterface;

class TIMSoundElem implements TIMMsgInterface
{
    /**
     * @param string $url 语音下载地址，可通过该 URL 地址直接下载相应语音
     * @param string $uuid 语音的唯一标识，客户端用于索引语音的键值
     * @param int $size 语音数据大小，单位：字节
     * @param int $second 语音时长，单位：秒
     * @param int $downloadFlag 语音下载方式标记。目前 Download_Flag 取值只能为2，表示可通过Url字段值的 URL 地址直接下载语音
     */
    public function __construct(public string $url, public string $uuid, public int $size, public int $second, public int $downloadFlag)
    {
    }

    public function output(): array
    {
        return [
            'MsgType'    => MsgType::TIM_SOUND_ELEM,
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