<?php

namespace StephaneCoinon\IDrive\Models;

use Carbon\Carbon;
use StephaneCoinon\IDrive\Model\Models;

class Event extends Model
{
    public static function new($attributes)
    {
        return new static([
            'id' => $attributes['id'] ?? null,
            'type' => $attributes['event'] ?? null,
            'date' => isset($attributes['date']) ? Carbon::parse($attributes['date']) : null,
        ]);
    }
}
