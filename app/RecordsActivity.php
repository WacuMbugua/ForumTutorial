<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Activity;
use ReflectionClass;
use ReflectionException;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) return;

       foreach (static::getActivitiesToRecord() as $event) {
           static::$event(function ($model) use ($event) {
               $model->recordActivity($event);
           });
           }
       }
       protected static function getActivitiesToRecord()
       {
           return ['created'];
    }
    protected function getActivityType($event)
    {
        try {
            $type = strtolower((new ReflectionClass($this))->getShortName());
        } catch (ReflectionException $e) {
        }
        return "{event}_{$type}";
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }
    public function activity()
    {
        return $this->MorphMany('App\Activity', 'subject')
    }
}
