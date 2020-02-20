
<div id="reply-{{ $reply->id }}" class="panel panel-default">
<div class="card">
    <div class="card-heading">
        <div class="level">
            <span class="flex">
                {{ $profileUser->name }} submitted a reply
                 <a href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a>
            </span>
        </div>
    </div>
    <div class="card-body">
        {{ $activity->subject->body }}
    </div>
</div>
