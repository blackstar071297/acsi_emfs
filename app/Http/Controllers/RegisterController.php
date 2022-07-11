<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
        
        $validator = Validator::make($request->all(),[
            'emp_no' => 'required|exists:emp_info,empno',
            'username' => 'required',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'access_level' => 'required',
            'position' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }else{
            $employee = new Employee();
            $user_info = DB::table('emp_info')->where('empno',$request->get('emp_no'))->first();
            
            $employee->useruniq = $user_info->empid;

            $employee->empno = $request->get('emp_no');
            $employee->firstname = $request->get('first_name');
            $employee->lastname = $request->get('last_name');
            $employee->username = $request->get('username');
            $employee->userpass = hash('sha256',$request->get('password')) ;
            $employee->useraccess = $request->get('access_level');
            $employee->position = $request->get('position');
            
            if($employee->save()){
                return 'success';
            }
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
