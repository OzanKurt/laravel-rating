<?php

namespace Kurt\Rating\Facades;

use Illuminate\Support\Facades\Facade;

class Rating extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'rating';
    }
}
