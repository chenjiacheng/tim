<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service\Sms;

use Chenjiacheng\Tim\Tests\TimTest;
use Chenjiacheng\Tim\Tim;

class BlackTest extends TimTest
{
    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGet()
    {
        $tim = new Tim($this->config);

        $result = $tim->sms->black('105')->get();
        $this->assertSame('OK', $result['ActionStatus']);
    }
}
