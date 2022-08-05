<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service;

use Chenjiacheng\Tim\Tests\TimTest;
use Chenjiacheng\Tim\Tim;

class ConversationTest extends TimTest
{
    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSetPortrait()
    {
        $tim = new Tim($this->config);

        $result = $tim->profile->setPortrait('105', [
            'Tag_Profile_IM_Nick'     => 'test105',
            'Tag_Profile_IM_Gender'   => 'Gender_Type_Male',
            'Tag_Profile_IM_BirthDay' => 20220801,
        ]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->profile->setPortrait(106, [
            'Tag_Profile_IM_Nick'     => 'test106',
            'Tag_Profile_IM_Gender'   => 'Gender_Type_Male',
            'Tag_Profile_IM_BirthDay' => 20220801,
        ]);
        $this->assertSame('OK', $result['ActionStatus']);
    }
}
