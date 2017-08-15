<?php

namespace Tests\Stubs;

use StephaneCoinon\IDrive\IDrive;
use StephaneCoinon\IDrive\Models\Event;
use StephaneCoinon\IDrive\Models\ServerAddress;

class FakeIDrive extends IDrive
{
    public $testCase;

    public function getServerAddress()
    {
        return new ServerAddress($this->testCase->getJsonFixture('serverAddress.json', true));
    }

    public function getEvents($year, $month)
    {
        return array_map(function ($item) {
            return Event::new(((array) $item)['@attributes']);
        }, $this->testCase->getXmlFixture('events.xml')['item']);
    }
}
