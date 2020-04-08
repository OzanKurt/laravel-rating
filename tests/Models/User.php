<?php

namespace Kurt\Rating\Tests\Models;

use Kurt\Rating\Traits\Rate\CanRate;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use CanRate;

    protected $guarded = [];

    protected $table = 'users';
}
