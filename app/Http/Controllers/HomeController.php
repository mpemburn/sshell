<?php

namespace App\Http\Controllers;

use App\Models\Connection;
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
        $connectionName = request('connect');

        if (Connection::where('id', '>=', '1')->first()) {
            return view('shell', ['connect' => $connectionName]);
        }

        return view('connection');

    }

    public function editConnection()
    {
        return view('connection');
    }
    public function editModifiers()
    {
        return view('modifier');
    }
    public function editScripts()
    {
        return view('script');
    }
}
