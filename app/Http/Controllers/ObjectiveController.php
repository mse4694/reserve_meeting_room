<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class ObjectiveController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Objective');
    }
}
