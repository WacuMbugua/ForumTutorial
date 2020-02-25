@extends('layouts.app')

@section('content')
    <thread-view inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-heading">
                        <a href=" route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}
                    </div>
                    @can('update', $thread)
                    <form action="{{$thread->path()}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-link">Delete Thread</button>
                    </form>
                    @endcan
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
                {{ $replies->links() }}
                @if(auth()->check())
                    <form method="POST" action="{{$thread->path() . '/replies'}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="What do you think?" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">login</a> to respond.</p>
                @endif
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                        This thread was created {{ $thread->created_at->diffForHumans() }} by
                        <a href="#">{{ $thread->creator->name }}</a> and currently
                        has
                        <b><span v-text="repliesCount"></span></b> {{ str::plural('reply', $thread->replies_count) }}.
                        </p>

                        <p>
                            <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </thread-view>
@endsection

