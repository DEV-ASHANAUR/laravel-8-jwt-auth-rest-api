<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->user = $this->guard()->user();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = $this->user->todos()->get(['id', 'title', 'body', 'completed', 'created_by']);
        return response()->json($todos->toArray());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'title' => 'required|string',
            'body' => 'required|string',
            'completed' => 'required|string'
        ]);
        if($validate->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validate->errors(),
            ],400);
        }
        $todo = new Todo();
        $todo->title = $request->title;
        $todo->body = $request->body;
        $todo->completed = $request->completed;

        if($this->user->todos()->save($todo)){
            return response()->json([
                'status' => true,
                'todo' => $todo,
            ]);
        }else{
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the todo could not be saved.',
                ]
            );

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $validate = Validator::make($request->all(),[
            'title' => 'required|string',
            'body' => 'required|string',
            'completed' => 'required|string'
        ]);
        if($validate->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validate->errors(),
            ],400);
        }
        $todo->title = $request->title;
        $todo->body = $request->body;
        $todo->completed = $request->completed;

        if($this->user->todos()->save($todo)){
            return response()->json([
                'status' => true,
                'todo' => $todo,
            ]);
        }else{
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the todo could not be saved.',
                ]
            );

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        if($todo->delete()){
            return response()->json([
                'status' => true,
                'message' => 'Data deleted Successfully',
                'todo' =>$todo
            ]);
        }else{
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the todo could not be deleted.',
                ]
            );
        }
    }
    protected function guard(){
        return Auth::guard();
    }
}
