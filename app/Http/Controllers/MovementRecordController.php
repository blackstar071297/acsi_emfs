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
        $record = new MovementRecord();
        $record->request_no = $request->request_no;
        if((int) $request->current_status == 3){
            $record->status_id = 4;
        }else{
            $record->status_id = (int) $request->current_status + 1;
        }
        
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
            
            if($form->save()){
                return true;
            }else{
                return false;
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
