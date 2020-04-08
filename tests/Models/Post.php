<?php

namespace Kurt\Rating\Tests\Models;

use Kurt\Rating\Traits\Rate\Rateable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Rateable;

    protected $guarded = [];

    protected $table = 'posts';
}
