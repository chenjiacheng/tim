<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Service\TIMMsgElement\TIMCustomElem;
use Chenjiacheng\Tim\Service\TIMMsgElement\TIMFaceElem;
use Chenjiacheng\Tim\Service\TIMMsgElement\TIMFileElem;
use Chenjiacheng\Tim\Service\TIMMsgElement\TIMImageElem;
use Chenjiacheng\Tim\Service\TIMMsgElement\TIMLocationElem;
use Chenjiacheng\Tim\Service\TIMMsgElement\TIMSoundElem;
use Chenjiacheng\Tim\Service\TIMMsgElement\TIMTextElem;
use Chenjiacheng\Tim\Service\TIMMsgElement\TIMVideoFileElem;

trait TIMMsgTrait
{
    protected array $msgBody;

    /**
     * 发送文本消息
     *
     * @param string $text
     *
     * @return $this
     */
    public function setTIMTextElem(string $text): static
    {
        $this->msgBody[] = (new TIMTextElem($text))->output();
        return $this;
    }

    /**
     * 发送位置消息
     *
     * @param string $dec
     * @param float $latitude
     * @param float $longitude
     *
     * @return $this
     */
    public function setTIMLocationElem(string $dec, float $latitude, float $longitude): static
    {
        $this->msgBody[] = (new TIMLocationElem($dec, $latitude, $longitude))->output();
        return $this;
    }

    /**
     * 发送表情消息
     *
     * @param int $index
     * @param string $data
     *
     * @return $this
     */
    public function setTIMFaceElem(int $index, string $data): static
    {
        $this->msgBody[] = (new TIMFaceElem($index, $data))->output();
        return $this;
    }

    /**
     * 发送自定义消息
     *
     * @param string $data
     * @param string $desc
     * @param string $ext
     * @param string $sound
     *
     * @return $this
     */
    public function setTIMCustomElem(string $data, string $desc, string $ext, string $sound): static
    {
        $this->msgBody[] = (new TIMCustomElem($data, $desc, $ext, $sound))->output();
        return $this;
    }

    /**
     * 发送语音消息
     *
     * @param string $url
     * @param string $uuid
     * @param int $size
     * @param int $second
     * @param int $downloadFlag
     *
     * @return $this
     */
    public function setTIMSoundElem(string $url, string $uuid, int $size, int $second, int $downloadFlag): static
    {
        $this->msgBody[] = (new TIMSoundElem($url, $uuid, $size, $second, $downloadFlag))->output();
        return $this;
    }

    /**
     * 发送图片消息
     *
     * @param string $url
     *
     * @return $this
     */
    public function setTIMImageElem(string $url): static
    {
        $this->msgBody[] = (new TIMImageElem($url, $this->getUUID()))->output();
        return $this;
    }

    /**
     * 发送文件消息
     *
     * @param string $url
     *
     * @return $this
     */
    public function setTIMFileElem(string $url): static
    {
        $this->msgBody[] = (new TIMFileElem($url, $this->getUUID()))->output();
        return $this;
    }

    /**
     * 发送视频消息
     *
     * @param string $videoUrl
     * @param string $videoUUID
     * @param string $videoSize
     * @param string $videoSecond
     * @param string $videoFormat
     * @param string $videoDownloadFlag
     * @param string $thumbUrl
     * @param string $thumbUUID
     * @param string $thumbSize
     * @param string $thumbWidth
     * @param string $thumbHeight
     * @param string $thumbFormat
     * @param string $thumbDownloadFlag
     *
     * @return $this
     */
    public function setTIMVideoFileElem(string $videoUrl, string $videoUUID, string $videoSize, string $videoSecond, string $videoFormat, string $videoDownloadFlag, string $thumbUrl, string $thumbUUID, string $thumbSize, string $thumbWidth, string $thumbHeight, string $thumbFormat, string $thumbDownloadFlag): static
    {
        $this->msgBody[] = (new TIMVideoFileElem($videoUrl, $videoUUID, $videoSize, $videoSecond, $videoFormat, $videoDownloadFlag, $thumbUrl, $thumbUUID, $thumbSize, $thumbWidth, $thumbHeight, $thumbFormat, $thumbDownloadFlag))->output();
        return $this;
    }
}