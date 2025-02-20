<?php

namespace App\Http\Controllers\cms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {

        return view('dashboard');
    }


}
