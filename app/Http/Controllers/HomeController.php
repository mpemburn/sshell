<?php

namespace App\Http\Controllers;

use App\Services\ShellService;
use Illuminate\Http\Request;

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
    public function index()
    {
        $remote = env('DEFAULT_REMOTE');
        $connection = (new ShellService())->getConnection($remote);

        return view('home', ['connection' => $connection]);
    }
}
