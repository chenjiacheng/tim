<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Constant;

/**
 * 消息类型
 */
class MsgType
{
    /**
     * 文本消息
     */
    const TIM_TEXT_ELEM = 'TIMTextElem';

    /**
     * 位置消息
     */
    const TIM_LOCATION_ELEM = 'TIMLocationElem';

    /**
     * 表情消息
     */
    const TIM_FACE_ELEM = 'TIMFaceElem';

    /**
     * 自定义消息
     */
    const TIM_CUSTOM_ELEM = 'TIMCustomElem';

    /**
     * 语音消息
     */
    const TIM_SOUND_ELEM = 'TIMSoundElem';

    /**
     * 图像消息
     */
    const TIM_IMAGE_ELEM = 'TIMImageElem';

    /**
     * 文件消息
     */
    const TIM_FILE_ELEM = 'TIMFileElem';

    /**
     * 视频消息
     */
    const TIM_VIDEO_FILE_ELEM = 'TIMVideoFileElem';
}