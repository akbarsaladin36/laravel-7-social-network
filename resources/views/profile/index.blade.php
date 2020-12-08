    @extends('layouts.app')

    @section('title', 'Profile')

    @section('content')

        <div class="container">

            @if(session('info'))
                <div class="alert alert-success">
                    {{ session('info') }}
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{$user->first_name}}'s Profile Information</div>
                        <div class="card-body">

                            @include('partials.userblock')
                            @if(Auth::user()->id === $user->id)
                                <a href="/profile/{{ $user->username }}/edit" class="ml-3 pl-5">Update Profile</a>
                            @endif
                            

                            @if(Auth::user()->hasFriendRequestPending($user))
                                <a href="#" class="btn btn-secondary disabled float-right">Friend request sending</a>
                            @elseif(Auth::user()->hasFriendRequestReceived($user))
                                <a href="/friends/accept/{{$user->username}}" class="btn btn-primary float-right">Accept friend request</a>
                            @elseif(Auth::user()->isFriendsWith($user))
                                <a href="/friends/delete/{{$user->username}}" class="btn btn-success float-right">My Friends</a>
                            @elseif(Auth::user()->id !== $user->id)
                                <a href="/friends/add/{{$user->username}}" class="btn btn-primary float-right">Add Friend</a>
                            @endif
                            
                            <div class="clearfix"></div>
                            <hr class="py-2">

                            <form action="/status" method="post">
                                @csrf
                                <div class="form-group">
                                    <textarea name="body" rows="3" class="form-control" placeholder="What's happening?"></textarea>
                                @error('body')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Post status</button>
                            </form>
                            <div class="clearfix"></div>

                            @if(!$statuses->count())
                            <p>{{$user->getName()}} hasn't posting anything yet.</p>
                            @else
                                @foreach ($statuses as $status)
                                    <div class="media py-2">
                                        <a href="/profile/{{ $status->user->username }}" class="pull-left">
                                            <img class="mr-3" src="{{ $status->user->getAvatarUrl() }}" alt="{{ $status->user->username }}">
                                        </a>
                                    <div class="media-body">
                                    <h5 class="mt-0"><a href="/profile/{{ $status->user->username }}">{{ $status->user->getName() }}</a></h5>
                                    <p>{{ $status->body }}</p>
                                    <ul class="list-inline">
                                        <li class="list-inline-item text-secondary">{{$status->created_at->diffForHumans()}}</li>
                                        @if($status->user->id !== Auth::user()->id)
                                            <li class="list-inline-item"><a href="/status/{{ $status->id }}/like">Like</a></li>
                                        @endif
                                            <li class="list-inline-item">{{ $status->likes->count() }} {{ Str::plural('like', $status->likes->count()) }}</li>
                                    </ul>
                                    </div>
                                </div>

                                @foreach ($status->replies as $reply)
                                <div class="media py-2 ml-5">
                                    <a href="/profile/{{ $reply->user->username }}" class="pull-left">
                                        <img class="mr-3" src="{{ $reply->user->getAvatarUrl() }}" alt="{{ $reply->user->username }}">
                                    </a>
                                <div class="media-body">
                                <h5 class="mt-0 mr-3"><a href="/profile/{{ $reply->user->username }}">{{ $reply->user->getName() }}</a></h5>
                                <p>{{ $reply->body }}</p>
                                <ul class="list-inline">
                                    <li class="list-inline-item text-secondary">{{$reply->created_at->diffForHumans()}}</li>
                                        @if($reply->user->id !== Auth::user()->id)
                                            <li class="list-inline-item"><a href="/status/{{ $reply->id }}/like">Like</a></li>
                                        @endif
                                            <li class="list-inline-item">{{ $reply->likes->count() }} {{ Str::plural('like', $reply->likes->count()) }}</li>
                                </ul>
                                </div>
                            </div>
                                @endforeach
                                    
                                @if ($authUserIsFriend || Auth::user()->id === $status->user->id)
                                    <form action="/status/{{$status->id}}/reply" method="post" class="mt-3 ml-5">
                                        @csrf
                                        <div class="form-group">
                                            <textarea name="reply-{{ $status->id }}" rows="3" class="form-control" placeholder="Write your replies.."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary float-right">Reply</button>
                                        <div class="clearfix"></div>
                                    </form>
                                @endif
                                
                                @endforeach

                            @endif

                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-md-offset-4">
                    <div class="card">
                        <div class="card-header">{{ $user->first_name }}'s friends</div>
                        <div class="card-body">

                            @if(!$user->friends()->count())
                                <p>{{ $user->first_name }} has no friends.</p>
                            @else
                                @foreach ($user->friends() as $user)
                                    <div class="media">
                                        <img class="mr-3 mb-3" src="{{ $user->getAvatarUrl() }}" alt="my-image">
                                        <div class="media-body">
                                        <a href="/profile/{{ $user->username }}"><h5 class="mt-0">{{ $user->getName() }}</h5></a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>
        
    @endsection