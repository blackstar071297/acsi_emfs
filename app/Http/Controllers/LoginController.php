<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Matrix;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\SessionGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;
use Hash;
use Carbon\Carbon;
use File;
use Crypt;
use Auth;

use Illuminate\Support\Facades\DB;
class LoginController extends Controller
{
    use AuthenticatesUsers;
    // public function __construct(){
    //     $this->middleware(['auth:employee','auth:sanctum'])->except('logout','login','isAdmin');
    // }
    public function checkToken(){
        if(Auth('sanctum')->check()){
            return 'true';
        }else{
            $user = Employee::where('username', Auth::guard('employee')->user()->empno)->first();
            $token = $user->createToken('employee_auth_token')->plainTextToken;
            $token = explode('|',$token);
            $token = $token[1];
            return response()->json(['token'=>$token],200);
        }
        return Auth('sanctum')->check();
    }
    public function autoLogin(Request $request){
        $matrix = Matrix::where('tsiempno',$request->empno)->first();
        $empno;

        if(!is_null($matrix)){
            $empno = $matrix->acsiempno;
        }else{
            $empno = $request->empno;
        }
        return redirect()->to('/auto-login/'.$empno);
    }
    public function login(Request $request){

        $validator = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }else{
            $user = Employee::where('username', $request->username)->first();
            if(count((array)$user) == 0){
                return response()->json(['errors'=>['invalid'=>['user not found!']]]);
            }
            if(!Auth::guard('employee')->attempt($request->all())){
                return response()->json(['errors'=>['username'=>['username and password not match']]]);
                // return response()->json(["errors"=>'username and password not match',]401);
            }
            
            
            $token = $user->createToken('employee_auth_token')->plainTextToken;
            $token = explode('|',$token);
            $token = $token[1];
            return response()->json(['token'=>$token],200);
        }
    }
    public function isLoggedIn(Request $request){
        
        if(Auth::guard('employee')->check()){
            return true;
        }
        auth('sanctum')->user()->currentAccessToken()->delete();
        return false;
    }
    public function logout(Request $request){
        
        if(Auth::guard('employee')->logout() == null && auth('sanctum')->user()->currentAccessToken()->delete()){
            return 'true';
        }else{
            return 'false';
        }
        // if($request->user()->currentAccessToken()->delete()){
        //     return "true";
        // }else{
        //     return "false";
        // }
    }
    
    public function getCurrentUser(){
        // return Auth::guard('employee')->user();
        return DB::table('emf_users')->select('firstname','lastname','useraccess','empno','useraccess','position')->where('empno',Auth::guard('employee')->user()->empno)->first();
    }
    public function checkUser(Request $request){
        return DB::table('emf_users')->select('firstname','lastname','useraccess','empno','useraccess','position')->where('empno',$request->emp_no)->first();
    }
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
