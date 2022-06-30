<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class EmployeeController extends Controller
{
    public function getPositions(){
        return $positions = DB::table('emp_positions')->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $users = DB::table('emp_info')->get();
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = [];
        $users = DB::table('emp_info')->where('empno',$id)->first();
        $info1 = DB::table('emp_comp')->where('empid',$users->empid)->first();

        $supervisor = DB::table('emp_info')->where('empno',$info1->esup)->first();
        $super_info = DB::table('emp_comp')->where('empid',$supervisor->empid)->first();
        $supervisor = (object) array_merge((array) $supervisor, ['info1'=> (array) $super_info]) ;

        $manager = DB::table('emp_info')->where('empno',$info1->emngr)->first();
        $man_info = DB::table('emp_comp')->where('empid',$manager->empid)->first();
        $manager = (object) array_merge((array) $manager, ['info1'=> (array) $man_info]) ;

        $info1 = (object) array_merge((array) $info1, ['manager'=> (array) $manager]);
        $info1 = (object) array_merge((array) $info1, ['supervisor'=> (array) $supervisor]) ;

        return (object) array_merge((array) $users, ['info1'=> (array) $info1]) ;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
