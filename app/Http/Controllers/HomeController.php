<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function Swagger\scan;
use Swagger\Serializer;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $swagger = scan(__DIR__."\Api");
//        return $swagger;
        return view('home');
    }
}
