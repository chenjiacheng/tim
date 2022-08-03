<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests;

use Chenjiacheng\Tim\Tim;
use PHPUnit\Framework\TestCase;

class TimTest extends TestCase
{
    protected array $config = [
        'sdkappid'   => '1400708817',
        'key'        => 'd182df719a269501ec4795f980aa3691cae60412335058c161c3467d3cb0f565',
        'identifier' => 'administrator',
    ];

    public function testTim()
    {
        $tim = new Tim($this->config);
        $config = $tim->getConfig();

        $this->assertIsArray($config);
    }
}
