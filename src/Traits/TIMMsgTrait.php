<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Traits;

use Chenjiacheng\Tim\Traits\TIMMsgElement\TIMCustomElem;
use Chenjiacheng\Tim\Traits\TIMMsgElement\TIMFaceElem;
use Chenjiacheng\Tim\Traits\TIMMsgElement\TIMFileElem;
use Chenjiacheng\Tim\Traits\TIMMsgElement\TIMImageElem;
use Chenjiacheng\Tim\Traits\TIMMsgElement\TIMLocationElem;
use Chenjiacheng\Tim\Traits\TIMMsgElement\TIMSoundElem;
use Chenjiacheng\Tim\Traits\TIMMsgElement\TIMTextElem;
use Chenjiacheng\Tim\Traits\TIMMsgElement\TIMVideoFileElem;

trait TIMMsgTrait
{
    public array $msgBody = [];

    /**
     * 设置文本消息元素
     *
     * @param string $text 消息内容
     *
     * @return $this
     */
    public function setTIMTextElem(string $text): static
    {
        $TIMMsg = new TIMTextElem($text);

        $this->msgBody[] = $TIMMsg->output();

        return $this;
    }

    /**
     * 设置位置消息元素
     *
     * @param string $dec 地理位置描述信息
     * @param float $latitude 纬度
     * @param float $longitude 经度
     *
     * @return $this
     */
    public function setTIMLocationElem(string $dec, float $latitude, float $longitude): static
    {
        $TIMMsg = new TIMLocationElem($dec, $latitude, $longitude);

        $this->msgBody[] = $TIMMsg->output();

        return $this;
    }

    /**
     * 设置表情消息元素
     *
     * @param int $index 表情索引，用户自定义
     * @param string $data 额外数据
     *
     * @return $this
     */
    public function setTIMFaceElem(int $index, string $data): static
    {
        $TIMMsg = new TIMFaceElem($index, $data);

        $this->msgBody[] = $TIMMsg->output();

        return $this;
    }

    /**
     * 设置自定义消息元素
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
        $TIMMsg = new TIMCustomElem($data, $desc, $ext, $sound);

        $this->msgBody[] = $TIMMsg->output();

        return $this;
    }

    /**
     * 设置语音消息元素
     *
     * @param string $url 语音下载地址，可通过该 URL 地址直接下载相应语音
     * @param string|null $uuid 语音的唯一标识，客户端用于索引语音的键值
     * @param int $size 语音数据大小，单位：字节
     * @param int $second 语音时长，单位：秒
     *
     * @return $this
     */
    public function setTIMSoundElem(string $url, string $uuid = null, int $size = 0, int $second = 0): static
    {
        $TIMMsg = new TIMSoundElem($url, $uuid ?? $this->getUUID(), $size, $second, 2);

        $this->msgBody[] = $TIMMsg->output();

        return $this;
    }

    /**
     * 设置图片消息元素
     *
     * @param array|string $image 原图、缩略图或者大图下载信息：type,size,width,height,url
     * @param string|null $uuid 图片的唯一标识，客户端用于索引图片的键值
     *
     * @return $this
     */
    public function setTIMImageElem(array|string $image, string $uuid = null): static
    {
        $imageInfoArray = [];

        if (is_array($image)) {
            foreach ($image as $item) {

                if (isset($suffix)) [$width, $height] = getimagesize($item['url']);
                else [$width, $height, $suffix] = getimagesize($item['url']);

                $imageInfoArray[] = [
                    'Type'   => $item['type'],
                    'Size'   => $item['size'] ?? 0,
                    'Width'  => $item['width'] ?? $width,
                    'Height' => $item['height'] ?? $height,
                    'URL'    => $item['url'],
                ];
            }
        } else {
            [$width, $height, $suffix] = getimagesize($image);
            $imageInfoArray[] = [
                'Type'   => 1,
                'Size'   => 0,
                'Width'  => $width,
                'Height' => $height,
                'URL'    => $image,
            ];
        }

        $imageFormat = match ($suffix ?? 0) {
            1 => 2,
            2 => 1,
            3 => 3,
            6 => 4,
            default => 255,
        };

        $TIMMsg = new TIMImageElem($uuid ?? $this->getUUID(), $imageFormat, $imageInfoArray);

        $this->msgBody[] = $TIMMsg->output();

        return $this;
    }

    /**
     * 设置文件消息元素
     *
     * @param string $url 文件下载地址，可通过该 URL 地址直接下载相应文件
     * @param string|null $uuid 文件的唯一标识，客户端用于索引文件的键值
     * @param int $fileSize 文件数据大小，单位：字节
     * @param string $fileName 文件名称
     *
     * @return $this
     */
    public function setTIMFileElem(string $url, string $uuid = null, int $fileSize = 0, string $fileName = ''): static
    {
        $TIMMsg = new TIMFileElem($url, $uuid ?? $this->getUUID(), $fileSize, $fileName, 2);

        $this->msgBody[] = $TIMMsg->output();

        return $this;
    }

    /**
     * 设置视频消息元素
     *
     * @param array|string $video 视频信息：url,uuid,size,second,format
     * @param array|string $thumb 视频缩略图信息：url,uuid,size,width,height,format
     *
     * @return $this
     */
    public function setTIMVideoFileElem(array|string $video, array|string $thumb): static
    {
        // 视频信息
        if (is_array($video)) {
            $videoUrl = $video['url'] ?? '';
            $videoUUID = $video['uuid'] ?? $this->getUUID();
            $videoSize = $video['size'] ?? 0;
            $videoSecond = $video['second'] ?? 0;
            $videoFormat = $video['format'] ?? '';
        } else {
            $videoUrl = $video;
            $videoUUID = $this->getUUID();
            $videoSize = 0;
            $videoSecond = 0;
            $videoFormat = '';
        }

        // 视频缩略图信息
        if (is_array($thumb)) {
            $thumbUrl = $thumb['url'] ?? '';
            $thumbUUID = $thumb['uuid'] ?? $this->getUUID();
            $thumbSize = $thumb['size'] ?? 0;
            $thumbWidth = $thumb['width'] ?? 0;
            $thumbHeight = $thumb['height'] ?? 0;
            $thumbFormat = $thumb['format'] ?? '';
        } else {
            $suffixMap = [
                1  => 'GIF', 2 => 'JPG', 3 => 'PNG', 4 => 'SWF',
                5  => 'PSD', 6 => 'BMP', 7 => 'TIFF', 8 => 'TIFF',
                9  => 'JPC', 10 => 'JP2', 11 => 'JPX', 12 => 'JB2',
                13 => 'SWC', 14 => 'IFF', 15 => 'WBMP', 16 => 'XBM'
            ];
            $thumbUrl = $thumb;
            $thumbUUID = $this->getUUID();
            $thumbSize = 0;
            [$thumbWidth, $thumbHeight, $thumbSuffix] = getimagesize($thumbUrl);
            $thumbFormat = $suffixMap[$thumbSuffix] ?? '';
        }

        $TIMMsg = new TIMVideoFileElem(
            $videoUrl, $videoUUID, $videoSize, $videoSecond, $videoFormat, 2,
            $thumbUrl, $thumbUUID, $thumbSize, $thumbWidth, $thumbHeight, $thumbFormat, 2
        );

        $this->msgBody[] = $TIMMsg->output();

        return $this;
    }
}