<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Group;

use Chenjiacheng\Tim\Constant\GroupApplyJoinOption;

class GroupInfo
{
    /**
     * @var string
     */
    public string $faceUrl;

    /**
     * @var string
     */
    public string $introduction;

    /**
     * @var string
     */
    public string $notification;

    /**
     * @var int
     */
    public int $maxMemberNum;

    /**
     * @var string
     */
    public string $applyJoinOption;

    /**
     * @var array
     */
    public array $appDefinedData;

    /**
     * GroupInfo constructor.
     * @param string $introduction 群简介，最长240字节
     * @param string $notification 群公告，最长300字节
     * @param string $faceUrl 群头像 URL，最长100字节
     * @param int $maxMemberNum 最大群成员数量，缺省时的默认值：付费套餐包上限
     * @param string $applyJoinOption 申请加群处理方式
     * @param array $appDefinedData 群组维度的自定义字段
     */
    public function __construct(string $introduction = '', string $notification = '',
                                string $faceUrl = '', int $maxMemberNum = 0,
                                string $applyJoinOption = GroupApplyJoinOption::NEED_PERMISSION,
                                array $appDefinedData = [])
    {
        $this->faceUrl = $faceUrl;
        $this->introduction = $introduction;
        $this->notification = $notification;
        $this->maxMemberNum = $maxMemberNum;
        $this->applyJoinOption = $applyJoinOption;
        $this->appDefinedData = $appDefinedData;
    }

    /**
     * @return array
     */
    public function output(): array
    {
        return [
            'Introduction' => $this->introduction,
            'Notification' => $this->notification,
            'FaceUrl'      => $this->faceUrl,
            'MaxMemberNum' => $this->maxMemberNum,
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
    public function setApplyJoinOption(string $applyJoinOption = GroupApplyJoinOption::NEED_PERMISSION): GroupInfo
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