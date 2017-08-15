<?php

namespace Tests\Feature;

use StephaneCoinon\IDrive\Models\Event;
use StephaneCoinon\IDrive\Models\ServerAddress;

trait TestsIDrive
{
    /** @test */
    function getting_api_server_address()
    {
        $address = $this->iDrive->getServerAddress();

        $this->assertInstanceOf(ServerAddress::class, $address);
    }

    /** @test */
    function getting_events()
    {
        $events = $this->iDrive->getEvents(date('Y'), date('m'));

        $this->assertTrue(is_array($events));
        $this->assertContainsOnlyInstancesOf(Event::class, $events);
    }
}
