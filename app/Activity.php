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
}
