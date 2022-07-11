<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class EmployeeController extends Controller
{
    public function getPositions(){
        return $positions = DB::table('emp_positions')->get();
    }
    public function getDepartments(){
        $positions = DB::table('departments')->where('DEPTENABLE',1)->get();
        foreach($positions as $key=>$position){
            $positions[$key]->DEPTNAME = ucwords($position->DEPTNAME);
        }
        return $positions;
    }
    public function getCostCenter(){
        return $positions = DB::table('costcenter')->where('ccenable',1)->get();
    }
    public function getSupervisor($id){
        $user = [];
        $users = DB::table('emp_info')->where('empno',$id)->first();
        $info1 = DB::table('emp_comp')->where('empid',$users->empid)->first();
        $user_pic = DB::table('emp_pic')->where('empid',$users->empid)->first();
        $sup_cost_center = DB::table('emp_comp')->where('esup',$users->empno)->where('eactive','Active')->first();

        $supervisor = DB::table('emp_info')->where('empno',$info1->esup)->first();
        
        if(!empty($supervisor)){
            $super_info = DB::table('emp_comp')->where('empid',$supervisor->empid)->first();
            $supervisor = (object) array_merge((array) $supervisor, ['info1'=> (array) $super_info]) ;
            
        }
        $manager = DB::table('emp_info')->where('empno',$info1->emngr)->first();
        if(!empty($manager)){
            $man_info = DB::table('emp_comp')->where('empid',$manager->empid)->first();
            $manager = (object) array_merge((array) $manager, ['info1'=> (array) $man_info]) ;
        }
        $info1 = (object) array_merge((array) $info1, ['manager'=> (array) $manager]);
        $info1 = (object) array_merge((array) $info1, ['supervisor'=> (array) $supervisor]) ;
        $info1 = (object) array_merge((array) $info1, ['emp_pic'=> (array) $user_pic]) ;
        $users = (object) array_merge((array) $users, ['info1'=> (array) $info1]) ;

        $users->info1['ecostcenter'] = $sup_cost_center->ecostcenter;
        $users->info1['ecurrdept'] = $sup_cost_center->ecurrdept;
        return $users;
    }
    public function getSuperior(){
        $superiors = DB::table('lsup')->where('sup_enabled',1)->get();
        
        foreach($superiors as $key=>$superior){
            $users = DB::table('emp_info')->where('empno',$superiors[$key]->empno)->first();
            $info1 = DB::table('emp_comp')->where('empid',$users->empid)->first();
            $users = (object) array_merge((array) $users, ['info1'=> (array) $info1]) ;
            
            $superiors[$key] = (object) array_merge((array) $superiors[$key], ['user'=> (array) $users]) ;
            
        }
        foreach($superiors as $key=>$superior){
            if($superior->user['info1']['eactive'] != 'Active'){
                unset($superiors[$key]);
            }
        }
        foreach($superiors as $key=>$superior){
            $sup_cost_center = DB::table('emp_comp')->where('esup',$superior->empno)->where('eactive','Active')->first();
            
            // if($superior->user['info1']['eactive'] != 'Active'){
            //     unset($superiors[$key]);
            // }
            if(!empty($sup_cost_center)){
                $superior->info1['ecostcenter'] = $sup_cost_center->ecostcenter;
            }
        }
        //remove VIP
        foreach($superiors as $key=>$superior){
            if($superior->empno == 'ACSI-170001'){
                unset($superiors[$key]);
            }
        }
        
        return $superiors;
    }
    
    public function getManager(){
        $managers = DB::table('lmngr')->where('mngr_enabled',1)->get();

        foreach($managers as $key=>$manager){
            $users = DB::table('emp_info')->where('empno',$managers[$key]->empno)->first();
            $info1 = DB::table('emp_comp')->where('empid',$users->empid)->first();
            $users =(object) array_merge((array) $users, ['info1'=> (array) $info1]) ;

            $managers[$key] = (object) array_merge((array) $managers[$key], ['user'=> (array) $users]) ;
        }
        foreach($managers as $key=>$manager){
            if($manager->user['info1']['eactive'] != 'Active'){
                unset($managers[$key]);
            }
        }
        //remove VIP
        foreach($managers as $key=>$manager){
            if($manager->empno == 'ACSI-170001'){
                unset($managers[$key]);
            }
        }
        return $managers;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = DB::table('emp_info')->get();
        foreach($users as $key=>$user){
            $info1 = DB::table('emp_comp')->where('empid',$user->empid)->first();
            $users[$key] = (object)array_merge((array) $users[$key], ['info1'=> (array) $info1]) ;
        };
        foreach($users as $key=>$user){
            if($user->info1['eactive'] != 'Active'){
                unset($users[$key]);
            }
        };
        //remove VIP
        foreach($users as $key=>$user){
            if($user->empno == 'ACSI-170001'){
                unset($users[$key]);
            }
        }
        
        return $users;
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
        $user_pic = DB::table('emp_pic')->where('empid',$users->empid)->first();

        $supervisor = DB::table('emp_info')->where('empno',$info1->esup)->first();
        
        if(!empty($supervisor)){
            $super_info = DB::table('emp_comp')->where('empid',$supervisor->empid)->first();
            $supervisor = (object) array_merge((array) $supervisor, ['info1'=> (array) $super_info]) ;
            
        }
        
        $manager = DB::table('emp_info')->where('empno',$info1->emngr)->first();
        if(!empty($manager)){
            $man_info = DB::table('emp_comp')->where('empid',$manager->empid)->first();
            $manager = (object) array_merge((array) $manager, ['info1'=> (array) $man_info]) ;
        }
        $info1 = (object) array_merge((array) $info1, ['manager'=> (array) $manager]);
        $info1 = (object) array_merge((array) $info1, ['supervisor'=> (array) $supervisor]) ;
        $info1 = (object) array_merge((array) $info1, ['emp_pic'=> (array) $user_pic]) ;
        $users = (object) array_merge((array) $users, ['info1'=> (array) $info1]) ;

        
        return $users;
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
