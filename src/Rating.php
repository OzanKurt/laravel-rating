<?php

namespace Kurt\Rating;

use Illuminate\Database\Eloquent\Relations\Relation;

class Rating
{
    public function rate($user, $rateable, $value, $type = 'default')
    {
        $queryData = $this->getQueryData($rateable, $type);

        return $user->ratings()->updateOrCreate($queryData, [
            'value' => $value,
        ]);
    }

    public function isRated($user, $rateable, $type = 'default')
    {
        return $user->ratings()->where(
            $this->getQueryData($rateable, $type)
        )->exists();
    }

    public function getRating($user, $rateable, $type = 'default')
    {
        return $user->ratings()->where(
            $this->getQueryData($rateable, $type)
        )->first();
    }

    public function getRatingValue($user, $rateable, $type = 'default')
    {
        return $this->getRating($user, $rateable, $type)->value;
    }

    public function getQueryData($rateable, $type): array
    {
        return [
            'rateable_id' => $rateable->id,
            'rateable_type' => $this->getRateableByClass($rateable),
            'rating_type' => $type,
        ];
    }

    public function resolveRatedItems($items)
    {
        $collection = collect();

        foreach ($items as $item) {
            $rateableClass = $this->getRateableByKey($item->rateable_type);

            $collection->push((new $rateableClass)->find($item->rateable_id));
        }

        return $collection;
    }

    private function getRateableByClass($rateable)
    {
        $rateable = get_class($rateable);

        if (in_array($rateable, Relation::$morphMap)) {
            $rateable = array_search($rateable, Relation::$morphMap);
        }

        return $rateable;
    }

    private function getRateableByKey($rateable)
    {
        if (array_key_exists($rateable, Relation::$morphMap)) {
            $rateable = Relation::$morphMap[$rateable];
        }

        return $rateable;
    }
}
