<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $users = DB::table('users')
            ->join('user_roles', 'role_id', '=', 'user_roles.id')
            ->select('users.*', 'user_roles.name as role_name');
        if($request->user()->role_name->name !== 'Admin') {
            $users = $users->whereNot('user_roles.name', '=', 'Admin');
            Log::info('pk');
        }
        $users = $users->paginate(6);
        return view('home', [
            'users' => $users
        ]);
    }
}
