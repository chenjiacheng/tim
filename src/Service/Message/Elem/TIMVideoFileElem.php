<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Message\Elem;

use Chenjiacheng\Tim\Contract\MessageElemInterface;
use JetBrains\PhpStorm\ArrayShape;

class TIMVideoFileElem implements MessageElemInterface
{
    protected string $videoUrl;
    protected string $videoUUID;
    protected string $videoSize;
    protected string $videoSecond;
    protected string $videoFormat;
    protected string $videoDownloadFlag;
    protected string $thumbUrl;
    protected string $thumbUUID;
    protected string $thumbSize;
    protected string $thumbWidth;
    protected string $thumbHeight;
    protected string $thumbFormat;
    protected string $thumbDownloadFlag;

    public function __construct(string $videoUrl,
                                string $videoUUID,
                                string $videoSize,
                                string $videoSecond,
                                string $videoFormat,
                                string $videoDownloadFlag,
                                string $thumbUrl,
                                string $thumbUUID,
                                string $thumbSize,
                                string $thumbWidth,
                                string $thumbHeight,
                                string $thumbFormat,
                                string $thumbDownloadFlag)
    {
        $this->videoUrl = $videoUrl;
        $this->videoUUID = $videoUUID;
        $this->videoSize = $videoSize;
        $this->videoSecond = $videoSecond;
        $this->videoFormat = $videoFormat;
        $this->videoDownloadFlag = $videoDownloadFlag;
        $this->thumbUrl = $thumbUrl;
        $this->thumbUUID = $thumbUUID;
        $this->thumbSize = $thumbSize;
        $this->thumbWidth = $thumbWidth;
        $this->thumbHeight = $thumbHeight;
        $this->thumbFormat = $thumbFormat;
        $this->thumbDownloadFlag = $thumbDownloadFlag;
    }

    #[ArrayShape(['MsgType' => "string", 'MsgContent' => "array"])]
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