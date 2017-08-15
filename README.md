# Client for iDrive API

This PHP package is a client for [iDrive](https://www.idrive.com) (cloud backup) API.

## Requirements

- PHP 7
- SimpleXML (ext-simplexml should be installed by default)

## Installation

```
composer require stephanecoinon/idrive:dev-master@dev
```

## Usage

```php
<?php

use StephaneCoinon\IDrive\IDrive;

require 'vendor/autoload.php';

$iDrive = IDrive::connect('uid', 'password');

// Get an array of devices backed up by iDrive
$devices = $iDrive->getDevices();

// Get an array of events in a given month
$events = $iDrive->getEvents($year = 2017, $month = 8);
```

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
