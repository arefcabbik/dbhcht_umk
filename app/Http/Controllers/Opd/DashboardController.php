<?php

namespace App\Http\Controllers\Opd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rkp;
use App\Models\Rka;

class DashboardController extends Controller
{
    public function index()
    {
        // Get counts for dashboard
        $rkp_count = Rkp::count();
        $rka_count = Rka::count();
        
        return view('opd.dashboard', compact('rkp_count', 'rka_count'));
    }
} 