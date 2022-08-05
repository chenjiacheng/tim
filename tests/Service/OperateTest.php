<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service;

use Chenjiacheng\Tim\Tests\TimTest;
use Chenjiacheng\Tim\Tim;

class OperateTest extends TimTest
{
    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetAppInfo()
    {
        $tim = new Tim($this->config);

        $result = $tim->operate->getAppInfo();
        $this->assertSame('OK', $result['ErrorInfo']);
    }
}
