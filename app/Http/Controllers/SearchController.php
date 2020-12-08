<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function getResults(Request $request)
    {
        $query = $request->input('query');

        if(!$query){
            return redirect('/timeline');
        }

        $users = User::where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', "%{$query}%")
                 ->orWhere('username', 'LIKE', "%{$query}%")
                 ->get();

        return view('search.index', compact('users'));
    }
}
