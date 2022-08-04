<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\TIMMsgElement;

use Chenjiacheng\Tim\Contract\TIMMsgInterface;
use JetBrains\PhpStorm\ArrayShape;

class TIMLocationElem implements TIMMsgInterface
{
    protected string $dec;
    protected float $latitude;
    protected float $longitude;

    public function __construct(string $dec, float $latitude, float $longitude)
    {
        $this->dec = $dec;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    #[ArrayShape(['MsgType' => "string", 'MsgContent' => "array"])]
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