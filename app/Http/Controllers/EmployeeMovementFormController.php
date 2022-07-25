<?php

namespace App\Http\Controllers;

use App\Models\EmployeeMovementForm;
use Illuminate\Http\Request;
use App\Models\MovementRecord;
use Illuminate\Support\Facades\DB;
use Auth;

use Validator;

class EmployeeMovementFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return EmployeeMovementForm::with('employee','requestor','records.status')->where('is_closed',0)->latest()->get();
    }
    public function fstForm()
    {
        //
        
        return EmployeeMovementForm::with('requestor','records.status','employee')->whereHas('employee',function($query){
            $query->where('empno',Auth::guard('employee')->user()->empno);
        })->where('is_closed',0)->latest()->get();
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
            'to_position' => ['required_if:move_position,true'],
            'to_job_status' => ['required_if:move_job_status,true'],
            'to_job_level' => ['required_if:move_job_level,true'],
            'to_role' => ['required_if:move_role,true'],
            'to_department' => ['required_if:move_department,true'],
            'to_cost_center' => ['required_if:move_cost_center,true'],
            'to_salary' => ['required_if:move_salary,true'],
            'to_allowance' => ['required_if:move_allowance,true'],
            'to_immediate_superior' => ['required_if:move_immediate_superior,true'],
            'to_manager' => ['required_if:move_manager,true'],
            'to_contract' => ['required_if:move_contract,true'],
            'to_others' => ['required_if:move_others,true'],
            'reason_for_movement' => 'required',
            'effectivity_date' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }else{
            $emf = new EmployeeMovementForm();
            $ctr = EmployeeMovementForm::whereYear('created_at','=',date('Y'))->get();
            $count = count($ctr,COUNT_RECURSIVE) + 1;
            $max = (4 - strlen(strval(count($ctr,COUNT_RECURSIVE)))) +  strlen(strval(count($ctr,COUNT_RECURSIVE)));
            $rpn = 'EMF' . date('Y') . '-' . str_pad($count,$max,'0',STR_PAD_LEFT);

            $emf->request_no = $rpn;
            $emf->emp_no = $request->emp_no;
            $emf->request_by = $request->request_by;
            $emf->from_position = $request->from_position;
            $emf->from_job_status = $request->from_job_status;
            $emf->from_job_level = $request->from_job_level;
            $emf->from_role = $request->from_role;
            $emf->from_cost_center = $request->from_cost_center;
            $emf->from_department = $request->from_department;
            $emf->from_immediate_superior = $request->from_immediate_superior;
            $emf->from_manager = $request->from_manager;
            $emf->from_salary = $request->from_salary;
            
            if($request->move_position == "true"){
                $emf->move_position = true;
                $emf->to_position = $request->to_position;
            }
            if($request->move_job_status == "true"){
                $emf->move_job_status = true;
                $emf->to_job_status = $request->to_job_status;
            }
            if($request->move_job_level == "true"){
                $emf->move_job_level = true;
                $emf->to_job_level = $request->to_job_level;
            }
            if($request->move_role == "true"){
                $emf->move_role = true;
                $emf->to_role = $request->to_role;
            }
            if($request->move_department == "true"){
                $emf->move_department = true;
                $emf->to_department = $request->to_department;
            }
            if($request->move_cost_center == "true"){
                $emf->move_cost_center = true;
                $emf->to_cost_center = $request->to_cost_center;
            }
            if($request->move_salary == "true"){
                $emf->move_salary = true;
                $emf->to_salary = $request->to_salary;
            }
            if($request->move_allowance == "true"){
                $emf->move_allowance  = true;
                $emf->to_allowance = $request->to_allowance;
            }
            if($request->move_immediate_superior == "true"){
                $emf->move_immediate_superior = true;
                $emf->to_immediate_superior = $request->to_immediate_superior;
            }
            if($request->move_manager == "true"){
                $emf->move_manager = true;
                $emf->to_manager = $request->to_manager;
            }
            if($request->move_contract == "true"){
                $emf->to_contract = $request->to_contract;
                $emf->move_contract = true;
            }
            if($request->move_others == "true"){
                $emf->move_others = true;
                $emf->to_others = $request->to_others;
            }
            $emf->hr_account_officer = $this->search_account_officer($emf);
            $emf->reason_for_movement = $request->reason_for_movement;
            $emf->effectivity_date = $request->effectivity_date;
            try{
                if($emf->save()){
                    $record = new MovementRecord();
                    $record->request_no = $rpn;
                    $record->status_id = 1;
                    try {
                        if($record->save()){
                            return 'success';
                        }
                    } catch (\Exception $e) {
                        return $e->getMessage();   // insert query
                    }
                }
            }
            catch(\Exception $e){
                // do task when error
                return $e->getMessage();   // insert query
            }
            return $emf;
        }
        
        
    }
    private function search_account_officer($form){
        if(($form->to_cost_center == 'Area 3') || ($form->to_cost_center == 'Tier 2' && $form->to_immediate_superior == 'ACSI-170010' && $form->move_immediate_superior == "true")){
            return 'ACSI-200722';
        }elseif(($form->to_cost_center == 'Area 4') || ($form->to_cost_center == 'Tier 2' && $form->to_immediate_superior == 'ACSI-170006' && $form->move_immediate_superior == "true")){
            return 'ACSI-200761';
        }elseif(($form->to_cost_center == 'Area 6') || ($form->to_cost_center == 'Tier 2' && $form->to_immediate_superior == 'ACSI-170208' && $form->move_immediate_superior == "true")){
            return 'ACSI-190545';
        }

        if(($form->from_cost_center == 'Area 3') || ($form->from_cost_center == 'Tier 2' && $form->from_immediate_superior == 'ACSI-170010' && $form->move_immediate_superior == "false")){
            return 'ACSI-200722';
        }elseif(($form->from_cost_center == 'Area 4') || ($form->from_cost_center == 'Tier 2' && $form->from_immediate_superior == 'ACSI-170006' && $form->move_immediate_superior == "false")){
            return 'ACSI-200761';
        }elseif(($form->from_cost_center == 'Area 6') || ($form->from_cost_center == 'Tier 2' && $form->from_immediate_superior == 'ACSI-170208' && $form->move_immediate_superior == "false")){
            return 'ACSI-190545';
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmployeeMovementForm  $employeeMovementForm
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeMovementForm $employeeMovementForm)
    {
        //
        return $form = EmployeeMovementForm::with('employee.info1','requestor.info1','records.status','current_manager.info1','current_superior.info1','new_superior.info1','new_manager.info1','account_officer.info1')->where('request_no',$employeeMovementForm->request_no)->first();
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmployeeMovementForm  $employeeMovementForm
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeMovementForm $employeeMovementForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployeeMovementForm  $employeeMovementForm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeMovementForm $employeeMovementForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmployeeMovementForm  $employeeMovementForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeMovementForm $employeeMovementForm)
    {
        //
    }
}
