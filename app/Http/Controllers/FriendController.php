<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function getFriendIndex()
    {
        $friends = Auth::user()->friends();
        $requests = Auth::user()->friendRequests();

        return view('friends.index', compact('friends', 'requests'));
    }

    public function getAddFriend($username)
    {
        $user = User::whereUsername($username)->first();

        if(!$user) {
            return redirect()->route('home')->with('info', 'User is not found. Please try again.');
        }

        if(Auth::user()->id === $user->id) {
            return redirect()->route('home');
        }

        if(Auth::user()->hasFriendRequestPending($user) || $user->hasFriendRequestPending(Auth::user())) {
            return redirect()->route('profile.show', ['username'=>$user->username]);
        }

        if(Auth::user()->isFriendsWith($user)) {
            return redirect()->route('profile.show', ['username'=>$user->username])
                             ->with('info', 'You are already friends!');
        }

        Auth::user()->addFriend($user);
        return redirect()->route('profile.show', ['username'=>$username])
                         ->with('info', 'Your friend request have been sent.');
        
    }

    public function getAcceptFriend($username)
    {
        $user = User::whereUsername($username)->first();

        if(!$user) {
            return redirect()->route('home')->with('info', 'User is not found. Please try again.');
        }

        if(!Auth::user()->hasFriendRequestReceived($user)) {
            return redirect()->route('home');
        }

        Auth::user()->acceptFriendRequest($user);

        return redirect()->route('profile.show', ['username'=>$username])
                         ->with('info', 'Your friend request have been accepted!');
    }

    public function getDeleteFriend($username)
    {
        $user = User::where('username', $username)->first();

        if(!$user) {
            return redirect()->route('home')->with('info', 'User is not found. Please try again.');
        }

        if(!Auth::user()->isFriendsWith($user)) {
            return redirect()->back();
        }

        Auth::user()->deleteFriend($user);

        return redirect()->back()->with('info', 'Your friends are deleted.');
    }
}
