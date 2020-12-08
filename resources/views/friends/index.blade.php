    @extends('layouts.app')

    @section('title', 'Friends')

    @section('content')
        
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('My Friends') }}</div>
                    <div class="card-body">

                        @if(!$friends->count())
                            <p>You have no friends.</p>
                        @else
                            @foreach ($friends as $user)
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

            <div class="col-md-4 col-md-offset-4">
                <div class="card">
                    <div class="card-header">Friends Requests</div>
                    <div class="card-body">

                        @if(!$requests->count())
                            <p>You have no friends requests.</p>
                        @else
                            @foreach ($requests as $user)
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