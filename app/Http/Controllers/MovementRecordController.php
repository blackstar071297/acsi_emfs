<?php

namespace App\Http\Controllers;

use App\Models\MovementRecord;
use Illuminate\Http\Request;
use App\Models\EmployeeMovementForm;

class MovementRecordController extends Controller
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
        $form = EmployeeMovementForm::where('request_no',$request->request_no)->first();
        $record = new MovementRecord();
        $record->request_no = $request->request_no;
        $approval_process = $this->choose_approval_process($form);
        $record->status_id = $this->choose_status($approval_process,$request->current_status,$form);
        
        if($record->save()){
            if($this->updateForm($request)){
                return 'success';
            }
        }
        return 'error';
    }
    private function updateForm($request){
        $form = EmployeeMovementForm::where('request_no',$request->request_no)->first();
        
            if($request->current_status == 1){
                $form->superior_accept_date = now()->toDateString();
            }
            if($request->current_status == 2){
                $form->manager_accept_date = now()->toDateString();
            }
            if($request->current_status == 3){
                $form->new_superior_accept_date = now()->toDateString();
            }
            if($request->current_status == 4){
                $form->new_manager_accept_date = now()->toDateString();
            }
            if($request->current_status == 5){
                $form->cable_head_accept_date = now()->toDateString();
            }
            if($request->current_status == 6){
                $form->employee_accept_date = now()->toDateString();
            }
            if($request->current_status == 7){
                $form->hr_accept_date = now()->toDateString();
            }
            if($request->current_status == 2 && $form->from_manager == $form->to_manager){
                $form->manager_accept_date = now()->toDateString();
                $form->new_manager_accept_date = now()->toDateString();
            }
            if($request->current_status == 4 && $form->to_manager == $form->to_manager){
                $form->new_manager_accept_date = now()->toDateString();
                $form->cable_head_accept_date = now()->toDateString();
            }
            if($form->save()){
                return true;
            }else{
                return false;
            }
    }
    private function choose_status($approval_process,$current_status,$form){
        if($approval_process == 1){
            if((int) $current_status == 2){
                return 5;
            }elseif($current_status == 3 && $form->from_manager == $form->to_manager){
                return 5;
            }elseif($current_status == 4 && $form->to_manager == 'ACSI-200634'){
                return 6;
            }else{
                return (int) $current_status + 1;
            }
        }elseif($approval_process == 2){
            if($current_status == 3 && $form->from_manager == $form->to_manager){
                return 5;
            }elseif($current_status == 4 && $form->to_manager == 'ACSI-200634'){
                return 6;
            }else{
                return (int) $current_status + 1;
            }
        }elseif($approval_process == 3){
            if((int) $current_status == 2){
                return 4;
            }elseif($current_status == 3 && $form->from_manager == $form->to_manager){
                return 5;
            }else{
                return (int) $current_status + 1;
            }
        }
    }
    private function choose_approval_process($form){
        if($form->move_position == 1 || $form->move_job_status == 1 || $form->move_job_level == 1 || $form->move_role == 1 || $form->move_salary == 1 || $form->move_allowance == 1 || $form->move_contract == 1  || $form->move_others == 1 && $form->move_department == 0 && $form->move_cost_center == 0 && $form->move_immediate_superior == 0 && $form->move_manager == 0){
            return 1;
        }elseif(($form->move_department == 1 && $form->move_cost_center == 1 && $form->move_immediate_superior == 1 && $form->move_manager == 1) && ($form->move_position == 1 || $form->move_job_status == 1 || $form->move_job_level == 1 || $form->move_role == 1 || $form->move_salary == 1 || $form->move_allowance == 1 || $form->move_contract == 1  || $form->move_others == 1)){
            return 2;
        }elseif(($form->move_immediate_superior == 1 && $form->move_manager == 1 && $form->move_department == 1 && $form->move_cost_center == 1) && ($form->move_position == 0 && $form->move_job_status == 0 && $form->move_job_level == 0 && $form->move_role == 0 && $form->move_salary == 0 && $form->move_allowance == 0 && $form->move_contract == 0  && $form->move_others == 0)) {
            return 3;
        }else{
            return 1;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MovementRecord  $movementRecord
     * @return \Illuminate\Http\Response
     */
    public function show(MovementRecord $movementRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MovementRecord  $movementRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(MovementRecord $movementRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MovementRecord  $movementRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MovementRecord $movementRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MovementRecord  $movementRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(MovementRecord $movementRecord)
    {
        //
    }
}
