<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];
    /*
     *
     *
     */
    public function path()
    {
        return "/threads/'{$this->channel->slug}/{$this->id}";
    }
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    public function creator()
    {
        return $this->belongsTo(user::class, 'user_id');
    }
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }


    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });
        static::deleting(function ($thread) {
            $thread->replies()->delete();
        });
    }
            static::created(function ($thread) {
                Activity::create([
                    'type' => 'created_' . strtolower((new \ReflectionClass($thread))->getShortName()),
                    'user_id' => auth()->id(),
                    'subject_id' => $thread->id,
                    'subject_type' => get_class($thread)
                ]);
            });
}
protected function recordActivity($event)
{
    Activity::create([
        'type' => 'created_' . strtolower((new \ReflectionClass($this))->getShortName()),
        'user_id' => auth()->id(),
        'subject_id' => $this->id,
        'subject_type' => get_class($this)
    ]);
}
