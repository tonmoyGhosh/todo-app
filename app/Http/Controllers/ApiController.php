<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TodoList;

class ApiController extends Controller
{
    public function todoView()
    {
        return view('todo.view');
    }

    public function getList()
    {
        $list = TodoList::orderBy('id','asc')->get();
        
        if($list)
        {
            $result =  array (
                'status' => true,
                'data'   => $list
            );
        }
        else 
        {
            $result =  array (
                'status' => false,
                'data'   => null
            );
        }

        return $result;
        
    }

    public function todoGenerate()
    {
        // foreach($resquest as $rec)
        // {
        //     return $rec;
        // }

        return json_encode($resquest['data']->data);
    }

   
}
