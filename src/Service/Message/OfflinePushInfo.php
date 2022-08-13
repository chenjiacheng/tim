<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Message;

class OfflinePushInfo
{
    /**
     * @param int $pushFlag 0表示推送，1表示不离线推送
     * @param string $title 离线推送标题
     * @param string $desc 离线推送内容
     * @param string $ext 离线推送透传内容
     * @param array $androidInfo Android 离线推送信息
     * @param array $apnsInfo Apns 离线推送信息
     */
    public function __construct(
        public int $pushFlag = 0,
        public string $title = '',
        public string $desc = '',
        public string $ext = '',
        public array $androidInfo = [],
        public array $apnsInfo = [])
    {
    }

    /**
     * @return array
     */
    public function output(): array
    {
        return [
            'PushFlag'    => $this->pushFlag,
            'Title'       => $this->title,
            'Desc'        => $this->desc,
            'Ext'         => $this->ext,
            'AndroidInfo' => $this->androidInfo,
            'ApnsInfo'    => $this->apnsInfo,
        ];
    }

    /**
     * @return int
     */
    public function getPushFlag(): int
    {
        return $this->pushFlag;
    }

    /**
     * @param int $pushFlag
     *
     *
     * @return OfflinePushInfo
     */
    public function setPushFlag(int $pushFlag): OfflinePushInfo
    {
        $this->pushFlag = $pushFlag;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return OfflinePushInfo
     */
    public function setTitle(string $title): OfflinePushInfo
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->desc;
    }

    /**
     * @param string $desc
     *
     * @return OfflinePushInfo
     */
    public function setDesc(string $desc): OfflinePushInfo
    {
        $this->desc = $desc;
        return $this;
    }

    /**
     * @return string
     */
    public function getExt(): string
    {
        return $this->ext;
    }

    /**
     * @param string $ext
     *
     * @return OfflinePushInfo
     */
    public function setExt(string $ext): OfflinePushInfo
    {
        $this->ext = $ext;
        return $this;
    }

    /**
     * @return array
     */
    public function getAndroidInfo(): array
    {
        return $this->androidInfo;
    }

    /**
     * @param array $androidInfo
     *
     * @return OfflinePushInfo
     */
    public function setAndroidInfo(array $androidInfo): OfflinePushInfo
    {
        $this->androidInfo = $androidInfo;
        return $this;
    }

    /**
     * @return array
     */
    public function getApnsInfo(): array
    {
        return $this->apnsInfo;
    }

    /**
     * @param array $apnsInfo
     *
     * @return OfflinePushInfo
     */
    public function setApnsInfo(array $apnsInfo): OfflinePushInfo
    {
        $this->apnsInfo = $apnsInfo;
        return $this;
    }
}