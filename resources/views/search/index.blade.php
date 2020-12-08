    @extends('layouts.app')

    @section('title', 'Search Results')

    @section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Search Results') }}</div>

                    <div class="card-body">
                        <p>Your search results for <h4>{{ Request::input('query') }}</h4></p>

                        @if(!$users->count())
                            <p>Your search results is not found. Please try again.</p>
                        @else
                            @foreach ($users as $user)
                                <div class="media">
                                    <img class="mr-3" src="{{ $user->getAvatarUrl() }}" alt="my-image">
                                    <div class="media-body">
                                    <a href="/profile/{{ $user->username }}"><h5 class="mt-0">{{ $user->getName() }}</h5></a>
                                    <p>@ {{$user->username}}</p>
                                    <p>{{$user->location}}</p>
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