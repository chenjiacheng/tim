<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service;

use Chenjiacheng\Tim\Tests\TimTest;
use Chenjiacheng\Tim\Tim;

class PushTest extends TimTest
{
    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPushAllMember()
    {
        $tim = new Tim($this->config);

        $result = $tim->push->setTIMTextElem('大家好吗')->pushAllMember();
        $this->assertSame('OK', $result['ActionStatus']);
    }
}
