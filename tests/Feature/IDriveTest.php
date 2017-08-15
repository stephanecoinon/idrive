<?php

namespace Tests\Feature;

use StephaneCoinon\IDrive\Support\Container;
use StephaneCoinon\IDrive\IDrive;
use Tests\Feature\TestsIDrive;
use Tests\TestCase;

/**
 * @group live
 */
class IDriveTest extends TestCase
{
    use TestsIDrive;

    public function setUp()
    {
        parent::setUp();

        $this->iDrive = IDrive::connect(
            Container::get('idrive.uid'),
            Container::get('idrive.password'),
            Container::get('idrive.api_server')
        );
    }
}
