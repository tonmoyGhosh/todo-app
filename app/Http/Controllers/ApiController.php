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

    public function todoGenerate(Request $request)
    {   
        $totalLength = count($request['data']);
        $totalData = $request['data'];
        $deleteId = $request['deleteId'];

        if($totalLength != 0)
        {       
            // Insert & Update Module Start 
            for($i=0; $i < $totalLength; $i++)
            {   
                $existRecord = TodoList::find($totalData[$i]['id']);
                
                if(!$existRecord)
                {   
                    $todo = new TodoList;
                    $todo->name = $totalData[$i]['name'];
                    $todo->save();
                }
                
                if($existRecord && $existRecord->name != $totalData[$i]['name'])
                {
                    $todo = TodoList::find($totalData[$i]['id']);
                    $todo->name = $totalData[$i]['name'];
                    $todo->update();
                }
            }
            // Insert & Update Module End 

            // Delete Module Start
            if($deleteId != 0)
            {
                $todo = TodoList::find($deleteId);
                $todo->delete();
            }
            // Delete Module End

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
        else 
        {
            $result =  array (
                'status' => false,
                'data'   => null
            );

            return $result;
        }
    }

   
}
