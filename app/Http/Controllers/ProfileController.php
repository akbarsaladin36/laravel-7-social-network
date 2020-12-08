<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile($username)
    {
        $user = User::whereUsername($username)->first();

        if(!$user) {
            abort(404);
        }

        $statuses = $user->statuses()->notReply()->get();

        return view('profile.index', compact('user', 'statuses'))->with('authUserIsFriend', Auth::user()->isFriendsWith($user));
    }

    public function editProfile($username)
    {
        $user = User::whereUsername($username)->first();

        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request, $username)
    {
        $user = User::whereUsername($username)->first();

        $attr = $request->validate([
            'first_name'=>'required|min:5|max:32',
            'last_name'=>'required|min:5|max:32',
            'location'=>'required|max:32',
        ]);

        $user->update($attr);

        return redirect()->route('profile.show', ['username'=>$username])->with('info', 'Your profile have been updated successfully!');
    }
}
