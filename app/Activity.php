<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public static function create(array $array)
    {
    }

    public static function first()
    {
    }

    public function subject()
    {
        return $this->mortphTo();
    }
    public static function fed($user, $take = 50)
    {
        return static::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->take($take)
            ->get()
            ->groupBy(function ($activity){
            return $activity->created_at->format('Y-m-d');
        });

    }
}
