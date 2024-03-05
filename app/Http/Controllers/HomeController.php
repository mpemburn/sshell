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
        $connectionName = request('connect');

        return view('shell', ['connect' => $connectionName]);
    }

    public function editModifiers()
    {
        return view('modifier-edit');
    }
    public function editScripts()
    {
        return view('script-edit');
    }
}
