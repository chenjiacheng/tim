<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Group;

class GroupInfo
{
    /**
     * @param string $introduction 群简介，最长240字节
     * @param string $notification 群公告，最长300字节
     * @param string $faceUrl 群头像 URL，最长100字节
     * @param int $maxMemberNum 最大群成员数量，缺省时的默认值：付费套餐包上限
     * @param string $applyJoinOption 申请加群处理方式
     * @param array $appDefinedData 群组维度的自定义字段
     */
    public function __construct(public string $introduction = '',
                                public string $notification = '',
                                public string $faceUrl = '',
                                public int $maxMemberNum = 0,
                                public string $applyJoinOption = '',
                                public array $appDefinedData = [])
    {
    }

    /**
     * @return array
     */
    public function output(): array
    {
        return [
            'Introduction'    => $this->introduction,
            'Notification'    => $this->notification,
            'FaceUrl'         => $this->faceUrl,
            'MaxMemberNum'    => $this->maxMemberNum,
            'ApplyJoinOption' => $this->applyJoinOption,
            'AppDefinedData'  => $this->appDefinedData,
        ];
    }

    /**
     * @return string
     */
    public function getIntroduction(): string
    {
        return $this->introduction;
    }

    /**
     * @param string $introduction 群简介，最长240字节
     *
     * @return GroupInfo
     */
    public function setIntroduction(string $introduction): GroupInfo
    {
        $this->introduction = $introduction;
        return $this;
    }

    /**
     * @return string
     */
    public function getNotification(): string
    {
        return $this->notification;
    }

    /**
     * @param string $notification 群公告，最长300字节
     *
     * @return GroupInfo
     */
    public function setNotification(string $notification): GroupInfo
    {
        $this->notification = $notification;
        return $this;
    }

    /**
     * @return string
     */
    public function getFaceUrl(): string
    {
        return $this->faceUrl;
    }

    /**
     * @param string $faceUrl 群头像 URL，最长100字节
     *
     * @return GroupInfo
     */
    public function setFaceUrl(string $faceUrl): GroupInfo
    {
        $this->faceUrl = $faceUrl;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxMemberNum(): int
    {
        return $this->maxMemberNum;
    }

    /**
     * @param int $maxMemberNum 最大群成员数量，缺省时的默认值：付费套餐包上限
     *
     * @return GroupInfo
     */
    public function setMaxMemberNum(int $maxMemberNum): GroupInfo
    {
        $this->maxMemberNum = $maxMemberNum;
        return $this;
    }

    /**
     * @return string
     */
    public function getApplyJoinOption(): string
    {
        return $this->applyJoinOption;
    }

    /**
     * @param string $applyJoinOption
     *
     * @return GroupInfo
     */
    public function setApplyJoinOption(string $applyJoinOption = ''): GroupInfo
    {
        $this->applyJoinOption = $applyJoinOption;
        return $this;
    }

    /**
     * @return array
     */
    public function getAppDefinedData(): array
    {
        return $this->appDefinedData;
    }

    /**
     * @param array $appDefinedData
     *
     * @return GroupInfo
     */
    public function setAppDefinedData(array $appDefinedData): GroupInfo
    {
        $this->appDefinedData = $appDefinedData;
        return $this;
    }
}