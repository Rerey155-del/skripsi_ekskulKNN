<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class KnnController extends Controller
{
    public function index(): View
    {
        return view('knn');
    }

    public function flowchart(): View
    {
        return view('flowchart');
    }
}
