<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Traits\TIMMsgElement;

use Chenjiacheng\Tim\Contract\TIMMsgInterface;

class TIMVideoFileElem implements TIMMsgInterface
{
    /**
     * @param string $videoUrl 视频下载地址。可通过该 URL 地址直接下载相应视频
     * @param string $videoUUID 视频的唯一标识，客户端用于索引视频的键值
     * @param int $videoSize 视频数据大小，单位：字节
     * @param int $videoSecond 视频时长，单位：秒
     * @param string $videoFormat 视频格式，例如 mp4
     * @param int $videoDownloadFlag 视频下载方式标记。目前 VideoDownloadFlag 取值只能为2，表示可通过VideoUrl字段值的 URL 地址直接下载视频
     * @param string $thumbUrl 视频缩略图下载地址。可通过该 URL 地址直接下载相应视频缩略图
     * @param string $thumbUUID 视频缩略图的唯一标识，客户端用于索引视频缩略图的键值
     * @param int $thumbSize 缩略图大小，单位：字节
     * @param int $thumbWidth 缩略图宽度，单位为像素
     * @param int $thumbHeight 缩略图高度，单位为像素
     * @param string $thumbFormat 缩略图格式，例如 JPG BMP 等
     * @param int $thumbDownloadFlag 视频缩略图下载方式标记。目前 ThumbDownloadFlag 取值只能为2，表示可通过ThumbUrl字段值的 URL 地址直接下载视频缩略图
     */
    public function __construct(
        public string $videoUrl,
        public string $videoUUID,
        public int $videoSize,
        public int $videoSecond,
        public string $videoFormat,
        public int $videoDownloadFlag,
        public string $thumbUrl,
        public string $thumbUUID,
        public int $thumbSize,
        public int $thumbWidth,
        public int $thumbHeight,
        public string $thumbFormat,
        public int $thumbDownloadFlag)
    {
    }

    public function output(): array
    {
        return [
            'MsgType'    => 'TIMVideoFileElem',
            'MsgContent' => [
                'VideoUrl'          => $this->videoUrl,
                'VideoUUID'         => $this->videoUUID,
                'VideoSize'         => $this->videoSize,
                'VideoSecond'       => $this->videoSecond,
                'VideoFormat'       => $this->videoFormat,
                'VideoDownloadFlag' => $this->videoDownloadFlag,
                'ThumbUrl'          => $this->thumbUrl,
                'ThumbUUID'         => $this->thumbUUID,
                'ThumbSize'         => $this->thumbSize,
                'ThumbWidth'        => $this->thumbWidth,
                'ThumbHeight'       => $this->thumbHeight,
                'ThumbFormat'       => $this->thumbFormat,
                'ThumbDownloadFlag' => $this->thumbDownloadFlag,
            ]
        ];
    }
}