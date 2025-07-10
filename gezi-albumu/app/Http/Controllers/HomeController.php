<?php

namespace App\Http\Controllers;

use App\Models\Trip;

class HomeController extends Controller
{
    public function index()
    {
        $trips = Trip::with(['user', 'photos'])->orderBy('trip_date', 'desc')->get();
        return view('welcome', compact('trips'));
    }
} 