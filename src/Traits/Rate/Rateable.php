<?php

namespace Kurt\Rating\Traits\Rate;

use Kurt\Rating\Models\Rating;

trait Rateable
{
    public function ratings($type = null)
    {
        $query = $this->morphMany(Rating::class, 'rateable');

        if ($type) {
            $query->where('rating_type', $type);
        }

        return $query;
    }

    public function ratingsAvg($type = 'default')
    {
        return $this->ratings()
            ->where('rating_type', $type)
            ->avg('value');
    }

    public function ratingsCount($type = 'default')
    {
        return $this->ratings()
            ->where('rating_type', $type)
            ->count();
    }
}
