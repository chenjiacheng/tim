<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service;

use Chenjiacheng\Tim\Tests\TimTest;
use Chenjiacheng\Tim\Tim;

class SnsTest extends TimTest
{
    public function testBlack()
    {
        $tim = new Tim($this->config);

        $result = $tim->sns->black('105');
        $this->assertIsObject($result);
    }
}
