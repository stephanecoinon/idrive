<?php

namespace Tests;

use Dotenv\Dotenv;
use Mockery;
use PHPUnit\Framework\TestCase as BaseTestCase;
use SimpleXMLElement;
use StephaneCoinon\IDrive\Support\Container;
use StephaneCoinon\IDrive\XmlReader;

class TestCase extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->loadDotEnv();

        // Reboot dependency container between tests
        Container::forceBoot();

        Container::add('idrive.uid', getenv('IDRIVE_UID'));
        Container::add('idrive.password', getenv('IDRIVE_PASSWORD'));
        Container::add('idrive.api_server', getenv('IDRIVE_API_SERVER'));
    }

    public function loadDotEnv()
    {
        (new Dotenv(__DIR__.'/..'))->load();
    }

    public function getFixturePath($path)
    {
        return __DIR__.'/Fixtures/'.$path;
    }

    public function getFixture($path)
    {
        return file_get_contents($this->getFixturePath($path));
    }

    public function getJsonFixture($path, $asArray = false)
    {
        return json_decode($this->getFixture($path), $asArray);
    }

    public function getXmlFixture($path)
    {
        return (array) new SimpleXMLElement($this->getFixture($path));
    }

    public function tearDown()
    {
        Mockery::close();
        Container::destroy();

        parent::tearDown();
    }
}
