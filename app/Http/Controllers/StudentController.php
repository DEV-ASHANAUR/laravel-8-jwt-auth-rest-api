<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Student::all();
        return response()->json($data->toArray());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required|between:3,100',
            'email' => 'required|email|unique:students',
            'roll' => 'required',
            'address' => 'required'

        ]);
        if($validate->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validate->errors(),
            ],400);
        }
        $data = new Student();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->roll = $request->roll;
        $data->address = $request->address;

        if($data->save()){
            return response()->json([
                'status' => true,
                'data' => $data,
            ]);
        }else{
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the todo could not be student info.',
                ]
            );

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Student::findOrFail($id);
        return response()->json($data->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $id;
        $validate = Validator::make($request->all(),[
            'name' => 'required|between:3,100',
            'email' => 'required|email',
            'roll' => 'required',
            'address' => 'required'

        ]);
        if($validate->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validate->errors(),
            ],400);
        }
        $student = Student::find($id);
        $student->name = $request->name;
        $student->email = $request->email;
        $student->roll = $request->roll;
        $student->address = $request->address;

        if($student->save()){
            return response()->json([
                'status' => true,
                'data' => $student,
            ]);
        }else{
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the todo could not be student info.',
                ]
            );

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Student::findOrFail($id);
        if($data->delete()){
            return response()->json([
                'status' => true,
                'message' => 'Data deleted Successfully',
                'data' =>$data
            ]);
        }else{
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the data could not be deleted.',
                ]
            );
        }
    }
}
