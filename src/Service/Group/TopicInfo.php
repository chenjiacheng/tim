<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Group;

class TopicInfo
{
    /**
     * @param string $faceUrl 话题头像 URL，最长100字节
     * @param string $notification 话题公告，最长300字节，使用 UTF-8 编码，1个汉字占3个字节
     * @param string $introduction 话题简介，最长240字节，使用 UTF-8 编码，1个汉字占3个字节
     * @param array $topicDefinedData 话题维度的自定义信息
     */
    public function __construct(public string $faceUrl = '',
                                public string $notification = '',
                                public string $introduction = '',
                                public array $topicDefinedData = [])
    {
    }

    /**
     * @return array
     */
    public function output(): array
    {
        return [
            'FaceUrl'          => $this->faceUrl,
            'Notification'     => $this->notification,
            'Introduction'     => $this->introduction,
            'TopicDefinedData' => array_map(function ($value, $key) {
                return ['Key' => $key, 'Value' => $value];
            }, $this->topicDefinedData, array_keys($this->topicDefinedData))
        ];
    }
}