<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Traits\TIMMsgElement;

use Chenjiacheng\Tim\Constant\MsgType;
use Chenjiacheng\Tim\Contract\TIMMsgInterface;

class TIMFileElem implements TIMMsgInterface
{
    /**
     * @param string $url 文件下载地址，可通过该 URL 地址直接下载相应文件
     * @param string $uuid 文件的唯一标识，客户端用于索引文件的键值
     * @param int $fileSize 文件数据大小，单位：字节
     * @param string $fileName 文件名称
     * @param int $downloadFlag 文件下载方式标记。目前 Download_Flag 取值只能为2，表示可通过Url字段值的 URL 地址直接下载文件
     */
    public function __construct(public string $url, public string $uuid, public int $fileSize, public string $fileName, public int $downloadFlag)
    {
    }

    public function output(): array
    {
        return [
            'MsgType'    => MsgType::TIM_FILE_ELEM,
            'MsgContent' => [
                'Url'           => $this->url,
                'UUID'          => $this->uuid,
                'FileSize'      => $this->fileSize,
                'FileName'      => $this->fileName,
                'Download_Flag' => $this->downloadFlag,
            ]
        ];
    }
}