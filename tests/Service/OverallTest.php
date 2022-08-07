<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service;

use Chenjiacheng\Tim\Tests\TimTest;
use Chenjiacheng\Tim\Tim;

class OverallTest extends TimTest
{
    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSetNoSpeaking()
    {
        $tim = new Tim($this->config);

        $result = $tim->overall->setNoSpeaking('101', 86400, 86400);
        $this->assertSame(0, $result['ErrorCode']);

        $result = $tim->overall->setNoSpeaking(101, 0, 0);
        $this->assertSame(0, $result['ErrorCode']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetNoSpeaking()
    {
        $tim = new Tim($this->config);

        $result = $tim->overall->getNoSpeaking('101');
        $this->assertSame(0, $result['ErrorCode']);

        $result = $tim->overall->getNoSpeaking(101);
        $this->assertSame(0, $result['ErrorCode']);
    }
}
