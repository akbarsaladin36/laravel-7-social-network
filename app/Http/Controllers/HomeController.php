<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::check()) {
            $statuses = Status::notReply()->where(function ($query) {
                return $query->where('user_id', Auth::user()->id)
                ->orWhereIn('user_id', Auth::user()->friends()->pluck('id'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

            return view('timeline.index', compact('statuses'));
        }

        return view('home');
    }
}
