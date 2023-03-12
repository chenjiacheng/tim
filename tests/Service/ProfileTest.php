<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service;

use Chenjiacheng\Tim\Constant\ProfileAdminForbidType;
use Chenjiacheng\Tim\Constant\ProfileAllowType;
use Chenjiacheng\Tim\Constant\ProfileGenderType;
use Chenjiacheng\Tim\Constant\ProfileTag;
use Chenjiacheng\Tim\Tests\TimTest;
use Chenjiacheng\Tim\Tim;

class ProfileTest extends TimTest
{
    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSet()
    {
        $tim = new Tim($this->config);

        $result = $tim->profile->set('101', [
            ProfileTag::NICK              => 'user101',
            ProfileTag::GENDER            => ProfileGenderType::MALE,
            ProfileTag::BIRTHDAY          => 20220801,
            ProfileTag::LOCATION          => '深圳',
            ProfileTag::SIGNATURE         => '这个人很懒，什么都没留下',
            ProfileTag::ALLOW_TYPE        => ProfileAllowType::NEED_CONFIRM,
            ProfileTag::LANGUAGE          => 1,
            ProfileTag::IMAGE             => 'https://avatars.githubusercontent.com/u/15870542',
            ProfileTag::ADMIN_FORBID_TYPE => ProfileAdminForbidType::NONE,
            ProfileTag::LEVEL             => 1,
            ProfileTag::ROLE              => 1,
        ]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->profile->set(102, [
            ProfileTag::NICK              => 'user102',
            ProfileTag::GENDER            => ProfileGenderType::FEMALE,
            ProfileTag::BIRTHDAY          => 20220801,
            ProfileTag::LOCATION          => '广州',
            ProfileTag::SIGNATURE         => '越努力越幸运',
            ProfileTag::ALLOW_TYPE        => ProfileAllowType::NEED_CONFIRM,
            ProfileTag::LANGUAGE          => 1,
            ProfileTag::IMAGE             => 'https://avatars.githubusercontent.com/u/15870542',
            ProfileTag::ADMIN_FORBID_TYPE => ProfileAdminForbidType::NONE,
            ProfileTag::LEVEL             => 2,
            ProfileTag::ROLE              => 2,
        ]);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGet()
    {
        $tim = new Tim($this->config);

        $result = $tim->profile->get(['101', 102], [
            ProfileTag::NICK,
            ProfileTag::GENDER,
            ProfileTag::BIRTHDAY,
            ProfileTag::LOCATION,
            ProfileTag::SIGNATURE,
            ProfileTag::ALLOW_TYPE,
            ProfileTag::LANGUAGE,
            ProfileTag::IMAGE,
            ProfileTag::ADMIN_FORBID_TYPE,
            ProfileTag::LEVEL,
            ProfileTag::ROLE,
        ]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->profile->get('101', [
            ProfileTag::NICK,
            ProfileTag::GENDER,
            ProfileTag::BIRTHDAY,
            ProfileTag::LOCATION,
            ProfileTag::SIGNATURE,
        ]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->profile->get(102, [
            ProfileTag::ALLOW_TYPE,
            ProfileTag::LANGUAGE,
            ProfileTag::IMAGE,
            ProfileTag::ADMIN_FORBID_TYPE,
            ProfileTag::LEVEL,
            ProfileTag::ROLE,
        ]);
        $this->assertSame('OK', $result['ActionStatus']);
    }
}
