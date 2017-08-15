<?php

namespace Tests\Feature;

use Mockery;
use StephaneCoinon\IDrive\IDrive;
use Tests\Stubs\FakeIDrive;
use Tests\TestCase;
use Tests\Feature\TestsIDrive;

/** @skip */
class FakeIDriveTest extends TestCase
{
    use TestsIDrive;

    public function setUp()
    {
        parent::setUp();

        $this->iDrive = new FakeIDrive;
        $this->iDrive->testCase = $this;
    }
}
