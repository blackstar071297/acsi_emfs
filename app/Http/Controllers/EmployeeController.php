<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\EmployeeInfo;
use App\Models\EmployeeInfo1;
use App\Models\EmployeeMovementForm;
use App\Models\MovementRecord;
use Hash;
use Notification;
use App\Notifications\ApprovalNotification;
Use \Carbon\Carbon;
class EmployeeController extends Controller
{
    public function test(){
        // return Carbon::now()->addDays(1);
        $forms = EmployeeMovementForm::with('employee.info1','requestor.info1','records.status','current_manager.info1','current_superior.info1','new_superior.info1','new_manager.info1','account_officer.info1')
        ->whereHas('records',function($query){
            $query->whereBetween('status_id',[6,8]);
        })
        ->where('is_closed',0)
        ->whereDate('effectivity_date', '<=', Carbon::now()->addDays(1))->get();

        foreach($forms as $key=>$form){
            $info = EmployeeInfo::where('empno',$form->emp_no)->first();
            $info1 = EmployeeInfo1::where('empid',$info->empid)->first();
            
            if($form->move_position == true){
                $info1->eposition = $form->to_position;
            }
            if($form->move_job_status == true){
                $info1->estatus = $form->to_job_status;
            }
            if($form->move_job_level == true){
                $info1->elevel = $form->to_job_level;
            }
            if($form->move_role == true){
                $info1->erole = $form->to_role;
            }
            if($form->move_department == true){
                $info1->ecurrdept = $form->to_department;
            }
            if($form->move_cost_center == true){
                $info1->ecostcenter = $form->to_cost_center;
                $servarea = ['N/A','Others','Area 3','Area 4','Area 6','Destiny','Special Projects','Tier 2','Quality Assurance','Strike force','Trainee']; 
                $info->servarea = array_search($form->to_cost_center,$servarea,true) == null || array_search($form->to_cost_center,$servarea,true) == '' ? 'N/A' : $form->to_cost_center ;
            }
            if($form->move_immediate_superior == true){
                $info1->esup = $form->to_immediate_superior;
            }
            if($form->move_manager == true){
                $info1->emngr = $form->to_manager;
            }
            $form->is_closed = 1;
            if($form->records[0]->status_id == 8){
                $record = new MovementRecord();
                $record->request_no = $form->request_no;
                $record->status_id = 9;
                
                $form->is_closed = 1;
                $form->save();
                if($record->save()){}
            }
            $form->save();
            $info1->save();
            $info->save();

            
        }
        return 'success';
    }
    public function generateUser(){
        $managers = DB::table('lmngr')->leftjoin('emp_info','lmngr.empno','=','emp_info.empno')->leftjoin('emp_comp','emp_comp.empid','=','emp_info.empid')->where('lmngr.mngr_enabled',1)->get();
        
        $mngr = [];
        foreach($managers as $key=>$manager){
            array_push($mngr,$managers[$key]->empno);
        }
        // return $mngr;
        $supervisor = DB::table('lsup')->leftjoin('emp_info','lsup.empno','=','emp_info.empno')->leftjoin('emp_comp','emp_comp.empid','=','emp_info.empid')->where('lsup.sup_enabled',1)->whereNotIn('lsup.empno',$mngr)->get();
        $hr = DB::table('emp_info')->leftjoin('emp_comp','emp_info.empid','=','emp_comp.empid')->where('emp_comp.eactive','Active')->where('emp_comp.ecurrdept','Human Resources')->get();
        foreach($managers as $key=>$manager){
            $employee = new Employee();
            $employee->useruniq = $manager->empid;

            $employee->empno = $manager->empno;
            $employee->firstname = $manager->firstname;
            $employee->lastname = $manager->lastname;
            $employee->username = $manager->empno;
            $employee->email = $manager->email_add == null ? null : $manager->email_add;
            $employee->userpass = bcrypt('password');
            $employee->useraccess = 'super_admin';
            $employee->position = 'manager';

            $employee->save();
        }
        foreach($supervisor as $key=>$manager){
            $employee = new Employee();
            $employee->useruniq = $manager->empid;

            $employee->empno = $manager->empno;
            $employee->firstname = $manager->firstname;
            $employee->lastname = $manager->lastname;
            $employee->username = $manager->empno;
            $employee->email = $manager->email_add == null ? null : $manager->email_add;
            $employee->userpass = bcrypt('password');
            $employee->useraccess = 'super_admin';
            $employee->position = 'supervisor';

            $employee->save();
        }

        foreach($hr as $key=>$manager){
            $employee = new Employee();
            $employee->useruniq = $manager->empid;

            $employee->empno = $manager->empno;
            $employee->firstname = $manager->firstname;
            $employee->lastname = $manager->lastname;
            $employee->username = $manager->empno;
            $employee->email = $manager->email_add == null ? null : $manager->email_add;
            $employee->userpass = bcrypt('password');
            $employee->useraccess = 'super_admin';
            $employee->position = 'hr_officer';

            $employee->save();
        }

        $fst = DB::table('emp_info')->leftjoin('emp_comp','emp_comp.empid','=','emp_info.empid')->where('emp_comp.eposition','Field Service Technician')->where('emp_comp.eactive','Active')->get();
        foreach($fst as $key=>$manager){
            $employee = new Employee();
            $employee->useruniq = $manager->empid;

            $employee->empno = $manager->empno;
            $employee->firstname = $manager->firstname;
            $employee->lastname = $manager->lastname;
            $employee->username = $manager->empno;
            $employee->userpass = bcrypt('password');
            $employee->email = $manager->email_add == null ? null : $manager->email_add;
            $employee->useraccess = 'viewer';
            $employee->position = 'fst';

            $employee->save();
        }
    }
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
