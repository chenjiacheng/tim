<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Traits\TIMMsgElement;

use Chenjiacheng\Tim\Contract\TIMMsgInterface;

class TIMLocationElem implements TIMMsgInterface
{
    /**
     * @param string $dec 地理位置描述信息
     * @param float $latitude 纬度
     * @param float $longitude 经度
     */
    public function __construct(public string $dec, public float $latitude, public float $longitude)
    {
    }

    public function output(): array
    {
        return [
            'MsgType'    => 'TIMLocationElem',
            'MsgContent' => [
                'Desc'      => $this->dec,
                'Latitude'  => $this->latitude,
                'Longitude' => $this->longitude,
            ]
        ];
    }
}