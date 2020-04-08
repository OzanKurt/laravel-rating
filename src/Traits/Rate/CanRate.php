<?php

namespace Kurt\Rating\Traits\Rate;

use Rating;
use Kurt\Rating\Models\Rating as RatingModel;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait CanRate
{
    public function ratings(): MorphMany
    {
        return $this->morphMany(RatingModel::class, 'model');
    }

    public function rate($model, $value, $type = 'default')
    {
        return Rating::rate($this, $model, $value, $type);
    }

    public function getRatingValue($model, $type = 'default')
    {
        return Rating::getRatingValue($this, $model, $type);
    }

    public function isRated($model, $type = 'default')
    {
        return Rating::isRated($this, $model, $type);
    }
}
