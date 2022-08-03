<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Traits;

use Chenjiacheng\Tim\Service\Message\Elem\TIMCustomElem;
use Chenjiacheng\Tim\Service\Message\Elem\TIMFaceElem;
use Chenjiacheng\Tim\Service\Message\Elem\TIMFileElem;
use Chenjiacheng\Tim\Service\Message\Elem\TIMImageElem;
use Chenjiacheng\Tim\Service\Message\Elem\TIMLocationElem;
use Chenjiacheng\Tim\Service\Message\Elem\TIMSoundElem;
use Chenjiacheng\Tim\Service\Message\Elem\TIMTextElem;
use Chenjiacheng\Tim\Service\Message\Elem\TIMVideoFileElem;

trait MessageTrait
{
    /**
     * 1：把消息同步到 From_Account 在线终端和漫游上；
     * 2：消息不同步至 From_Account；
     * 若不填写默认情况下会将消息存 From_Account 漫游
     *
     * @var int
     */
    protected int $syncOtherMachine;

    /**
     * 该字段只能填1或2，其他值是非法值
     * 1：表示实时消息导入，消息计入未读计数
     * 2：表示历史消息导入，消息不计入未读
     * @var int
     */
    protected int $syncFromOldSystem;

    /**
     * 消息离线保存时长（单位：秒），最长为7天（604800秒）
     * 若设置该字段为0，则消息只发在线用户，不保存离线
     * 若设置该字段超过7天（604800秒），仍只保存7天
     * 若不设置该字段，则默认保存7天
     *
     * @var int
     */
    protected int $msgLifeTime;

    /**
     * 消息序列号（32位无符号整数），后台会根据该字段去重及进行同秒内消息的排序，详细规则请看本接口的功能说明。若不填该字段，则由后台填入随机数
     *
     * @var int
     */
    protected int $msgSeq;

    /**
     * 消息回调禁止开关，只对本条消息有效
     * ForbidBeforeSendMsgCallback 表示禁止发消息前回调
     * ForbidAfterSendMsgCallback 表示禁止发消息后回调
     *
     * @var array
     */
    protected array $forbidCallbackControl;

    /**
     * 消息发送控制选项，是一个 String 数组，只对本条消息有效。
     * "NoUnread"表示该条消息不计入未读数。
     * "NoLastMsg"表示该条消息不更新会话列表。
     * "WithMuteNotifications"表示该条消息的接收方对发送方设置的免打扰选项生效（默认不生效）。
     *
     * @var array
     */
    protected array $sendMsgControl;

    /**
     * 消息自定义数据（云端保存，会发送到对端，程序卸载重装后还能拉取到）
     *
     * @var string
     */
    protected string $cloudCustomData;

    /**
     * 离线推送信息配置
     *
     * @var array
     */
    protected array $offlinePushInfo;

    /**
     * 发送文本消息
     *
     * @param string $text
     * @return mixed
     */
    public function sendText(string $text): mixed
    {
        return $this->sendMsg(new TIMTextElem($text));
    }

    /**
     * 发送位置消息
     *
     * @param string $dec
     * @param float $latitude
     * @param float $longitude
     * @return mixed
     */
    public function sendLocation(string $dec, float $latitude, float $longitude): mixed
    {
        return $this->sendMsg(new TIMLocationElem($dec, $latitude, $longitude));
    }

    /**
     * 发送表情消息
     *
     * @param int $index
     * @param string $data
     * @return mixed
     */
    public function sendFace(int $index, string $data): mixed
    {
        return $this->sendMsg(new TIMFaceElem($index, $data));
    }

    /**
     * 发送自定义消息
     *
     * @param string $data
     * @param string $desc
     * @param string $ext
     * @param string $sound
     * @return mixed
     */
    public function sendCustom(string $data, string $desc, string $ext, string $sound): mixed
    {
        return $this->sendMsg(new TIMCustomElem($data, $desc, $ext, $sound));
    }

    /**
     * 发送语音消息
     *
     * @param string $url
     * @param string $uuid
     * @param int $size
     * @param int $second
     * @param int $downloadFlag
     * @return mixed
     */
    public function sendSound(string $url, string $uuid, int $size, int $second, int $downloadFlag): mixed
    {
        return $this->sendMsg(new TIMSoundElem($url, $uuid, $size, $second, $downloadFlag));
    }

    /**
     * 发送图片消息
     *
     * @param string $url
     * @return mixed
     */
    public function sendImage(string $url): mixed
    {
        return $this->sendMsg(new TIMImageElem($url, $this->getUUID()));
    }

    /**
     * 发送文件消息
     *
     * @param string $url
     * @return mixed
     */
    public function sendFile(string $url): mixed
    {
        return $this->sendMsg(new TIMFileElem($url, $this->getUUID()));
    }

    /**
     * 发送视频
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
     * @return mixed
     */
    public function sendVideo(string $videoUrl, string $videoUUID, string $videoSize, string $videoSecond, string $videoFormat, string $videoDownloadFlag, string $thumbUrl, string $thumbUUID, string $thumbSize, string $thumbWidth, string $thumbHeight, string $thumbFormat, string $thumbDownloadFlag): mixed
    {
        return $this->sendMsg(new TIMVideoFileElem($videoUrl, $videoUUID, $videoSize, $videoSecond, $videoFormat, $videoDownloadFlag, $thumbUrl, $thumbUUID, $thumbSize, $thumbWidth, $thumbHeight, $thumbFormat, $thumbDownloadFlag));
    }

    /**
     * @param bool $bool true：把消息同步到 From_Account 在线终端和漫游上；false：消息不同步至 From_Account；
     *
     * @return $this
     */
    public function syncOtherMachine(bool $bool = true): static
    {
        $this->syncOtherMachine = $bool ? 1 : 2;
        return $this;
    }

    /**
     * 获取随机UUID
     *
     * @return string
     */
    public function getUUID(): string
    {
        return (microtime(true) * 1000) . '_' . rand(100000000, 999999999);
    }

    /**
     * @return int
     */
    public function getMsgRandom(): int
    {
        return rand(100000000, 999999999);
    }

    /**
     * @param bool $bool false 表示禁止发消息前回调
     *
     * @return $this
     */
    public function beforeCallback(bool $bool = true): static
    {
        !$bool && $this->forbidCallbackControl[] = 'ForbidBeforeSendMsgCallback';
        return $this;
    }

    /**
     * @param bool $bool false 表示禁止发消息后回调
     *
     * @return $this
     */
    public function afterCallback(bool $bool = true): static
    {
        !$bool && $this->forbidCallbackControl[] = 'ForbidAfterSendMsgCallback';
        return $this;
    }

    /**
     * @param false $bool true 表示该条消息不计入未读数。
     *
     * @return $this
     */
    public function noUnread(bool $bool = false): static
    {
        $bool && $this->sendMsgControl[] = 'NoUnread';
        return $this;
    }

    /**
     * @param false $bool true 表示该条消息不更新会话列表。
     *
     * @return $this
     */
    public function noLastMsg(bool $bool = false): static
    {
        $bool && $this->sendMsgControl[] = 'NoLastMsg';
        return $this;
    }

    /**
     * @param false $bool true 表示该条消息的接收方对发送方设置的免打扰选项生效（默认不生效）。
     *
     * @return $this
     */
    public function withMuteNotifications(bool $bool = false): static
    {
        $bool && $this->sendMsgControl[] = 'WithMuteNotifications';
        return $this;
    }

    /**
     * @param string $cloudCustomData 消息自定义数据（云端保存，会发送到对端，程序卸载重装后还能拉取到）
     *
     * @return $this
     */
    public function setCloudCustomData(string $cloudCustomData): static
    {
        $this->cloudCustomData = $cloudCustomData;
        return $this;
    }

    /**
     * @param array $offlinePushInfo 离线推送信息配置
     *
     * @return $this
     */
    public function setOfflinePushInfo(array $offlinePushInfo): static
    {
        $this->offlinePushInfo = $offlinePushInfo;
        return $this;
    }

    /**
     * @param int $msgLifeTime 消息离线保存时长（单位：秒），最长为7天（604800秒）若设置该字段为0，则消息只发在线用户，不保存离线
     *
     * @return $this
     */
    public function setMsgLifeTime(int $msgLifeTime = 604800): static
    {
        $this->msgLifeTime = $msgLifeTime;
        return $this;
    }

    /**
     * @param int $msgSeq
     *
     * @return $this
     */
    public function setMsgSeq(int $msgSeq): static
    {
        $this->msgSeq = $msgSeq;
        return $this;
    }

    /**
     * @param int $syncFromOldSystem
     * @return MessageTrait
     */
    public function setSyncFromOldSystem(int $syncFromOldSystem = 1): MessageTrait
    {
        $this->syncFromOldSystem = $syncFromOldSystem;
        return $this;
    }
}