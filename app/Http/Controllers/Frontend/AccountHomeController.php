<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountHomeController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('welcome');
    }
}
