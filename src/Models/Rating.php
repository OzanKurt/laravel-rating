<?php

namespace Kurt\Rating\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Rating extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ratings';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'value' => 'integer',
    ];

    /**
     * Get the model that rated the rateable.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the model that has been rated.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function rateable(): MorphTo
    {
        return $this->morphTo();
    }
}
