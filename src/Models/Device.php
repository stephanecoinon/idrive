<?php

namespace StephaneCoinon\IDrive\Models;

use Carbon\Carbon;
use StephaneCoinon\IDrive\Model\Models;

class Device extends Model
{
    public static function new($attributes)
    {
        return new static([
            'id' => $attributes['device_id'] ?? null,
            'uniqueId' => $attributes['uniqueId'] ?? null,
            'serverRoot' => $attributes['server_root'] ?? null,
            'nickname' => $attributes['nick_name'] ?? null,
            'loc' => $attributes['loc'] ?? null,
            'ip' => $attributes['ip'] ?? null,
            'bucketCreatedAt' => Carbon::parse($attributes['bucket_ctime']),
            'bucketType' => $attributes['bucket_type'] ?? null,
            'os' => $attributes['os'] ?? null,
        ]);
    }
}
