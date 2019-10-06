<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::latest()->get();
        return view('todos.index', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatetor = \Validator::make($request->all(), [
            'description' => 'required',
        ]);

        if($validatetor->fails()){
            return response()->json(['status' => false, 'data' => $validatetor->errors()]);
        }

        Todo::create($request->all());  
        return response()->json(['status' => true, 'data' => 'Todo created successfully']);
    }
}
