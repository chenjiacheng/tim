<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service;

use Chenjiacheng\Tim\Tests\TimTest;
use Chenjiacheng\Tim\Tim;

class CallbackTest extends TimTest
{
    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testVerify()
    {
        $tim = new Tim($this->config);

        $sign = 'a5d271b35bd72858cdf1ad0b9dfbf037d19146062c0ecb712a0a3235489d6021';
        $requestTime = 1676091353;
        $token = 'e10adc3949ba59abbe56e057f20f883e';
        $result = $tim->callback->verify($sign, $requestTime, $token);
        $this->assertSame(true, $result);

        $result = $tim->callback->verify($sign, $requestTime, 'xxx');
        $this->assertSame(false, $result);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testOk()
    {
        $tim = new Tim($this->config);

        $result = $tim->callback->ok();
        $result = json_decode($result, true);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->callback->ok(200);
        $result = json_decode($result, true);
        $this->assertSame(200, $result['ErrorCode']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidArgumentException
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testFail()
    {
        $tim = new Tim($this->config);

        $result = $tim->callback->fail();
        $result = json_decode($result, true);
        $this->assertSame('FAIL', $result['ActionStatus']);

        $result = $tim->callback->fail(404);
        $result = json_decode($result, true);
        $this->assertSame(404, $result['ErrorCode']);
    }
}
