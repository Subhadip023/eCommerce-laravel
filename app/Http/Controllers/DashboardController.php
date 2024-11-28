<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Get the authenticated user

        // Redirect based on user role
        if ($user->hasRole('admin')) {
            return view('dashboard.admin'); // Admin-specific view
        }

        if ($user->hasRole('editor')) {
            return view('dashboard'); // Editor-specific view
        }

        return view('dashboard'); // Default user view
    }
}
