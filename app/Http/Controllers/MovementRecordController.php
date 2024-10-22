<?php

namespace App\Http\Controllers;

use App\Models\MovementRecord;
use Illuminate\Http\Request;
use App\Models\EmployeeMovementForm;
use App\Models\Employee;
use App\Notifications\ApprovalNotification;
use Auth;

class MovementRecordController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $form = EmployeeMovementForm::where('request_no', $request->request_no)->first();
        $record = new MovementRecord();
        $record->request_no = $request->request_no;
        $approval_process = $this->choose_approval_process($form);
        $record->status_id = $this->choose_status($approval_process, $request->current_status, $form);

        if ($record->save()) {
            if ($this->updateForm($request)) {
                return 'success';
            }
        }
        return 'error';
    }

    public function cancelled(Request $request)
    {
        $form = EmployeeMovementForm::where('request_no', $request->request_no)->first();
        $form->canceled_by = Auth::guard('employee')->user()->empno;
        $form->date_canceled = now()->toDateString();

        $record = new MovementRecord();
        $record->request_no = $request->request_no;
        $record->status_id = 10;
        $record->remarks = $request->remarks;

        if ($record->save() && $form->save()) {
            $this->sendEmail($form->requested_by, $request->request_no, $record->status_id);
            return 'success';
        }
        return 'error';
    }

    public function returned(Request $request)
    {
        $form = EmployeeMovementForm::where('request_no', $request->request_no)->first();
        $records = MovementRecord::where('request_no', $request->request_no)->latest()->get();

        $this->resetAcceptDates($records[0]->status_id, $form);

        if (!$form->save()) return 'error 1';
        if (!$records[0]->delete()) return 'error 2';

        $record = MovementRecord::where('request_no', $request->request_no)->latest()->first();
        $record->remarks = $request->remarks;

        if ($record->save()) {
            $this->sendReturnNotification($records[0]->status_id, $form, $request->request_no);
            return 'success';
        }
        return 'error';
    }

    private function updateForm($request)
    {
        $form = EmployeeMovementForm::where('request_no', $request->request_no)->first();

        $this->setAcceptDates($request->current_status, $form);

        return $form->save();
    }

    private function choose_status($approval_process, $current_status, $form)
    {
        if ($approval_process == 1) {
            return $this->statusLogicOne($current_status, $form);
        } elseif ($approval_process == 2) {
            return $this->statusLogicTwo($current_status, $form);
        } elseif ($approval_process == 3) {
            return $this->statusLogicThree($current_status, $form);
        }
    }

    private function statusLogicOne($current_status, $form)
    {
        switch ($current_status) {
            case 1:
                return 2; // 5 - Pending Approval, 6 - Pending Acknowledgement
            case 2:
                return 6; // 4 - Pending Acknowledgement
            case 3:
                return 4; // Move to Pending Acknowledgement
            case 5:
                return 6; // Pending Acknowledgement
            case 7:
                return ($form->effectivity_date <= now()->toDateString()) ? 9 : 8; // 9 - Accepted, 8 - Effectivity Date Passed
            default:
                return (int) $current_status + 1; // Increment the status
        }
    }

    private function statusLogicTwo($current_status, $form)
    {
        switch ($current_status) {
            case 1:
                return 2;
            case 2:
                return ($form->from_manager != $form->to_manager) ? 4 : 5; // 4 - Pending Acknowledgement
            case 4:
                return 5; // Pending Approval
            case 5:
                return 6; // Pending Acknowledgement
            case 7:
                return ($form->effectivity_date <= now()->toDateString()) ? 9 : 8; // 9 - Accepted
            default:
                return (int) 2; // Increment the status
        }
    }

    private function statusLogicThree($current_status, $form)
    {
        switch ($current_status) {
            case 1:
                return $this->isSpecialManager($form->from_manager) ? 6 : 5;
            case 2:
                return 4; // Move to Pending Acknowledgement
            case 3:
                return 5; // Pending Approval
            case 4:
                return ($this->isSpecialManager($form->to_manager)) ? 5 : 6; // 6 - Pending Acknowledgement
            case 7:
                return ($form->effectivity_date <= now()->toDateString()) ? 9 : 8; // 9 - Accepted
            default:
                return (int) $current_status + 1; // Increment the status
        }
    }

    private function isSpecialManager($manager)
    {
        return in_array($manager, ['ACSI-170001', 'ACSI-200634']);
    }

    private function choose_approval_process($form)
    {
        if ($form->move_immediate_superior || $form->move_manager || $form->move_department || $form->move_cost_center) {
            return 2;
        }
        return 1;
    }

    private function sendEmail($approver_emp_no, $request_no, $status_id)
    {
        $approver = Employee::where('username', 'ACSI-220838')->first();

        if ($approver && $approver->email) {
            $details = $this->getEmailDetails($status_id, $request_no);
            $approver->notify(new ApprovalNotification($details));
        }
    }

    private function getEmailDetails($status_id, $request_no)
    {
        $subjectMap = [
            6 => 'Pending acknowledgement',
            7 => 'Pending acknowledgement',
            1 => 'Pending Approval',
            2 => 'Pending Approval',
            4 => 'Pending Approval',
            5 => 'Pending Approval',
            10 => 'Request cancelled',
            11 => 'Request returned'
        ];

        $bodyMap = [
            6 => 'You have pending acknowledgement...',
            1 => 'You have pending approval...',
            10 => 'Your request has been cancelled.',
            11 => 'Request returned.'
        ];

        return [
            'subject' => "{$subjectMap[$status_id]} ($request_no)",
            'body' => $bodyMap[$status_id] ?? '',
            'action' => 'http://tsi-acsi1.webhop.biz/acsi/dashboards/home'
        ];
    }

    private function resetAcceptDates($status_id, $form)
    {
        if ($status_id == 2) $form->superior_accept_date = null;
        elseif ($status_id == 4) $form->manager_accept_date = null;
        elseif ($status_id == 5) $form->new_manager_accept_date = null;
    }

    private function setAcceptDates($status, $form)
    {
        $dates = [
            1 => 'superior_accept_date',
            2 => 'manager_accept_date',
            3 => 'new_superior_accept_date',
            4 => 'new_manager_accept_date',
            5 => 'cable_head_accept_date',
            6 => 'hr_accept_date',
            7 => 'employee_accept_date',
            8 => 'is_closed'
        ];

        if (isset($dates[$status])) {
            $form->{$dates[$status]} = now()->toDateString();
        }
    }

    private function sendReturnNotification($status_id, $form, $request_no)
    {
        $employeeFieldMap = [
            1 => 'requested_by',
            2 => 'from_immediate_superior',
            4 => 'from_manager',
            5 => 'to_manager'
        ];

        if (isset($employeeFieldMap[$status_id])) {
            $this->sendEmail($form->{$employeeFieldMap[$status_id]}, $request_no, 11);
        }
    }
}
