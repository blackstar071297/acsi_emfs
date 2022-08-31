<?php

namespace App\Http\Controllers;

use App\Models\MovementRecord;
use Illuminate\Http\Request;
use App\Models\EmployeeMovementForm;
use App\Models\Employee;
use App\Notifications\ApprovalNotification;

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
                // if($record->status_id == 2){
                //     $this->sendEmail($form->from_manager,$request->request_no,$record->status_id);
                // }elseif($record->status_id == 4){
                //     $this->sendEmail($form->to_immediate_superior,$request->request_no,$record->status_id);
                // }elseif($record->status_id == 5){
                //     $this->sendEmail('ACSI-200634',$request->request_no,$record->status_id);
                // }elseif($record->status_id == 6){
                //     $this->sendEmail($form->hr_account_officer,$request->request_no,$record->status_id);
                // }elseif($record->status_id == 7){
                //     $this->sendEmail($form->emp_no,$request->request_no,$record->status_id);
                // }
                return 'success';
            }
        }
        return 'error';
    }
    public function cancelled(Request $request){
        $form = EmployeeMovementForm::where('request_no',$request->request_no)->first();
        $record = new MovementRecord();
        $record->request_no = $request->request_no;
        $approval_process = 0;
        $record->status_id = 10;
        $record->remarks = $request->remarks;
        if($record->save()){
            // $this->sendEmail($form->requested_by,$request->request_no,$record->status_id);
            return 'success';
        }
        return 'error';
    }
    public function returned(Request $request){
        $form = EmployeeMovementForm::where('request_no',$request->request_no)->first();
        $records = MovementRecord::where('request_no',$request->request_no)->latest()->get();
        
        if($records[0]->status_id == 2){
            $form->superior_accept_date = null;
        }elseif($records[0]->status_id == 4){
            $form->manager_accept_date = null;
        }elseif($records[0]->status_id == 5  && $form->from_manager == $form->to_manager){
            $form->manager_accept_date = null;
        }elseif($records[0]->status_id == 5){
            $form->new_manager_accept_date = null;
        }
        if(!$form->save()){
            return 'error 1';
        }
        if(!$records[0]->delete()){
            return 'error 2';
        }

        $record = MovementRecord::where('request_no',$request->request_no)->latest()->first();
        $record->remarks = $request->remarks;

        if($record->save()){
            // if($records[0]->status_id == 1){
            //     $this->sendEmail($form->requested_by,$request->request_no,11);
            // }elseif($records[0]->status_id == 2){
            //     $this->sendEmail($form->from_immediate_superior,$request->request_no,11);
            // }elseif($records[0]->status_id == 4){
            //     $this->sendEmail($form->from_manager,$request->request_no,11);
            // }elseif($records[0]->status_id == 5){
            //     $this->sendEmail($form->to_manager,$request->request_no,11);
            // }
            return 'success';
        }

        return $form[0];
    }
    private function updateForm($request){
        $form = EmployeeMovementForm::where('request_no',$request->request_no)->first();
        
            if($request->current_status == 1){
                $form->superior_accept_date = now()->toDateString();
            }
            if($request->current_status == 2 && $form->from_manager != $form->to_manager){
                $form->manager_accept_date = now()->toDateString();
            }
            if($request->current_status == 3){
                $form->new_superior_accept_date = now()->toDateString();
            }
            if($request->current_status == 4 && $form->to_manager != 'ACSI-200634'){
                $form->new_manager_accept_date = now()->toDateString();
            }
            if($request->current_status == 5){
                $form->cable_head_accept_date = now()->toDateString();
            }
            if($request->current_status == 6){
                $form->hr_accept_date = now()->toDateString();
            }
            if($request->current_status == 7){
                $form->employee_accept_date = now()->toDateString();
            }
            if($request->current_status == 8){
                $form->is_closed = true;
            }
            if($request->current_status == 2 && $form->from_manager == $form->to_manager){
                $form->manager_accept_date = now()->toDateString();
                $form->new_manager_accept_date = now()->toDateString();
            }
            if($request->current_status == 4 && $form->to_manager == 'ACSI-200634'){
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
            if($current_status == 2 && $form->from_manager != 'ACSI-200634' ){
                return 5;
            }elseif($current_status == 2 && $form->from_manager == 'ACSI-200634'){
                return 6;
            }elseif($current_status == 7 && $form->effectivity_date <= now()->toDateString()){
                return 9;
            }
            else{
                return (int) $current_status + 1;
            }
        }elseif($approval_process == 2){
            if($current_status == 2 && $form->from_manager == $form->to_manager){
                return 5;
            }elseif($current_status == 2 && $form->from_manager != $form->to_manager){
                return 4;
            }elseif($current_status == 4 && $form->to_manager == 'ACSI-200634'){
                return 6;
            }elseif($current_status == 4 && $form->to_manager != 'ACSI-200634'){
                return 5;
            }elseif($current_status == 7 && $form->effectivity_date <= now()->toDateString()){
                return 9;
            }
            else{
                return (int) $current_status + 1;
            }
        }elseif($approval_process == 3){
            if((int) $current_status == 2 && $form->from_manager != $form->to_manager){
                return 4;
            }elseif($current_status == 2 && $form->from_manager == $form->to_manager){
                return 5;
            }elseif($current_status == 4 && $form->to_manager != 'ACSI-200634'){
                return 5;
            }elseif($current_status == 4 && $form->to_manager == 'ACSI-200634'){
                return 6;
            }elseif($current_status == 7 && $form->effectivity_date <= now()->toDateString()){
                return 9;
            }
            else{
                return (int) $current_status + 1;
            }
        }
    }
    private function choose_approval_process($form){
        if(($form->move_position == 1 || $form->move_job_status == 1 || $form->move_job_level == 1 || $form->move_role == 1 || $form->move_salary == 1 || $form->move_allowance == 1 || $form->move_contract == 1  || $form->move_others == 1) && ($form->move_department == 0 && $form->move_cost_center == 0 && $form->move_immediate_superior == 0 && $form->move_manager == 0)){
            return 1;
        }elseif(($form->move_department == 1 && $form->move_cost_center == 1 && $form->move_immediate_superior == 1 && $form->move_manager == 1) && ($form->move_position == 1 || $form->move_job_status == 1 || $form->move_job_level == 1 || $form->move_role == 1 || $form->move_salary == 1 || $form->move_allowance == 1 || $form->move_contract == 1  || $form->move_others == 1)){
            return 2;
        }elseif(($form->move_immediate_superior == 1 && $form->move_manager == 1 && $form->move_department == 1 && $form->move_cost_center == 1) && ($form->move_position == 0 && $form->move_job_status == 0 && $form->move_job_level == 0 && $form->move_role == 0 && $form->move_salary == 0 && $form->move_allowance == 0 && $form->move_contract == 0  && $form->move_others == 0)) {
            return 3;
        }
    }
    private function sendEmail($approver_emp_no,$request_no,$status_id){
        $approver = Employee::where('username',$approver_emp_no)->first();
        $details = [];
        
        if(!is_null($approver) && !is_null($approver->email)){
            if($status_id == 6 || $status_id == 7){
                $details = [
                    'subject' => 'Pending acknowledgement(ACSI EMS)',
                    'body' => 'You have pending acknowledgement,Kindly go to your Dashboard and Click the EMS icon to approve',
                    'action' => 'http://tsi-acsi1.webhop.biz/acsi/dashboards/home'
                ];
            }elseif($status_id == 1 || $status_id == 2 || $status_id == 4 || $status_id == 5){
                $details = [
                    'subject' => 'Pending Approval(ACSI EMS)',
                    'body' => 'You have pending approval,Kindly go to your Dashboard and Click the EMS icon to approve',
                    'action' => 'http://tsi-acsi1.webhop.biz/acsi/dashboards/home'
                ];
            }elseif($status_id == 10){
                $details = [
                    'subject' => 'Request cancelled(ACSI EMS)',
                    'body' => 'Your request has been cancelled,,Kindly go to your Dashboard and Click the EMS icon to view',
                    'action' => 'http://tsi-acsi1.webhop.biz/acsi/dashboards/home'
                ];
            }elseif($status_id == 11){
                $details = [
                    'subject' => 'Request returned(ACSI EMS)',
                    'body' => 'Request returned.',
                    'action' => 'http://tsi-acsi1.webhop.biz/acsi/dashboards/home'
                ];
            }
        }
        $approver->notify(new ApprovalNotification($details));
        
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
