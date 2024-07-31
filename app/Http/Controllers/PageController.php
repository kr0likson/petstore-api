<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('pets.index');
    }

    public function create()
    {
        return view('pets.create');
    }

    public function edit($id)
    {
        return view('pets.edit', compact('id'));
    }
}
