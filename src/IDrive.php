<?php

namespace StephaneCoinon\IDrive;

use StephaneCoinon\IDrive\Models\Device;
use StephaneCoinon\IDrive\Models\Event;
use StephaneCoinon\IDrive\Models\ServerAddress;
use StephaneCoinon\IDrive\Http\Request;
use StephaneCoinon\IDrive\Http\Response;
use StephaneCoinon\IDrive\Support\Container;

/**
 * iDrive API client.
 */
class IDrive
{
    /** @var string Host name/IP of server used to get the API server address */
    public $evsServer = 'evs.idrive.com';

    /** @var string API server host/IP */
    protected $webApiServer;

    /** @var string iDrive user id */
    protected $uid;

    /** @var string iDrive user password */
    protected $password;


    /**
     * Connect to API server.
     *
     * @param string      $uid          iDrive user id
     * @param string      $password     iDrive user password
     * @param string|null $webApiServer API server host/IP or null to discover it
     * @return static
     */
    public static function connect($uid, $password, $webApiServer = null)
    {
        // This method should be the very first one called
        // so let's boot the IoC container
        Container::boot();

        $instance = new static;

        $instance->uid = $uid;
        $instance->password = $password;
        $instance->webApiServer = $webApiServer ?: $instance->resolveApiServer();

        return $instance;
    }

    /**
     * Resolve the API server host name.
     *
     * @return string
     */
    public function resolveApiServer()
    {
        return $this->getServerAddress()->webApiServer;
    }

    /**
     * Make a request to iDrive API.
     *
     * @param  string $endpoint    API endpoint
     * @param  array  $params      request parameters
     * @param  string|null $server override API server hostname/IP,
     *                             or null to use the one set on connect()
     * @return StephaneCoinon\IDrive\Http\Response
     */
    public function request($endpoint, $params = [], $server = null)
    {
        return Container::get(Request::class)
            ->post($server ?: $this->webApiServer, $endpoint, array_merge([
                'uid' => $this->uid,
                'pwd' => $this->password,
            ], $params));
    }

    /**
     * Get API server address.
     *
     * @return StephaneCoinon\IDrive\Models\ServerAddress
     * @throws Exception when request failed or api response is malformed
     */
    public function getServerAddress()
    {
        $response = $this->request('evs/getServerAddress', [], $this->evsServer);

        // @TODO handle if response is not ok

        return ServerAddress::new($response->decoded);
    }

    /**
     * Get the list of devices registered on iDrive accont.
     *
     * @return array
     */
    public function getDevices()
    {
        $response = $this->request('evs/listDevices');

        // @TODO handle if response is not ok

        return array_map(function ($device) {
            return Device::new($device);
        }, $response->get('contents', []));
    }

    /**
     * Get the list of events.
     *
     * @return array
     */
    public function getEvents($year, $month)
    {
        $response = $this->request('evs/getEvents', compact('year', 'month'));

        // @TODO handle if response is not ok

        return array_map(function ($item) {
            return Event::new((array) $item);
        }, $response->decoded['item']);
    }
}
