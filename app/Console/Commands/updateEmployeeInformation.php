<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EmployeeInfo;
use App\Models\EmployeeInfo1;
use App\Models\EmployeeMovementForm;

class updateEmployeeInformation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:employee_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Employee data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $forms = EmployeeMovementForm::with('employee.info1','requestor.info1','records.status','current_manager.info1','current_superior.info1','new_superior.info1','new_manager.info1','account_officer.info1')
        ->whereHas('records',function($query){
            $query->whereBetween('status_id',[6,8]);
        })
        ->where('is_closed',0)
        ->whereDate('effectivity_date', '<=', date('Y-m-d'))->get();

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
                $info->servarea = $form->to_cost_center;
            }
            if($form->move_immediate_superior == true){
                $info1->esup = $form->to_immediate_superior;
            }
            if($form->move_manager == true){
                $info1->emngr = $form->to_manager;
            }
            if($form->records[0]->status_id == 8){
                $record = new MovementRecord();
                $record->request_no = $form->request_no;
                $record->status_id = 9;
                
                $form->is_closed = true;
                $form->save();
                if($record->save()){}
            }
            $info1->save();
            $info->save();
        }
    }
}
