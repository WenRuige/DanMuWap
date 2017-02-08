<?php

namespace App\Http\Controllers;

use Log;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function test()
    {

        Log::info('hello world');
    }
}
