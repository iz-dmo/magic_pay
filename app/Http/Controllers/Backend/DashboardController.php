<?php

namespace App\Http\Controllers\Backend;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function Dashboard()
    {
        return view('backend.home');
    }

    
}
