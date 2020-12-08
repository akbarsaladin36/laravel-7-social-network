    @extends('layouts.app')

    @section('title', 'Edit Profile')

    @section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Profile') }}</div>

                    <div class="card-body">

                        <form action="/profile/{{ Auth::user()->username }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="form-group">
                              <label for="first_name">First Name</label>
                              <input type="text" class="form-control" name="first_name" value="{{ old('first_name') ?? $user->first_name }}">
                            @error('first_name')
                              <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            </div>
                            

                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') ?? $user->last_name }}">
                            @error('last_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            </div>
                            

                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" class="form-control" name="location" value="{{ old('location') ?? $user->location }}">
                            @error('location')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            </div>
                            

                            <button type="submit" class="btn btn-success">Save Profile</button>
                            
                        </form>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
        
    @endsection