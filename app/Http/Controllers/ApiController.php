<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function todoView()
    {
        return view('todo.view');
    }

    public function todoCreate()
    {
        
    }

    public function todoUpdate($id)
    {

    }
}
