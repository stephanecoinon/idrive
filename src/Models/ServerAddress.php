<?php

namespace StephaneCoinon\IDrive\Models;

use StephaneCoinon\IDrive\Models\Model;

class ServerAddress extends Model
{
    public static function new($attributes)
    {
        return new static([
            'cmdUtilityServer' => $attributes['cmdUtilityServer'] ?? null,
            'cmdUtilityServerIP' => $attributes['cmdUtilityServerIP'] ?? null,
            'webApiServer' => $attributes['webApiServer'] ?? null,
            'webApiServerIP' => $attributes['webApiServerIP'] ?? null,
            'dedup' => $attributes['dedup'] ?? null,
        ]);
    }
}
