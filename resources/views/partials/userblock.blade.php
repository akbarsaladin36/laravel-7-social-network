<div class="media">
    <img class="mr-3" src="{{ $user->getAvatarUrl() }}" alt="my-image">
    <div class="media-body">
      <h5 class="mt-0">{{ $user->getName() }}</h5>
      <p>@ {{$user->username}}</p>
      <p>{{$user->location}}</p>
    </div>
  </div>