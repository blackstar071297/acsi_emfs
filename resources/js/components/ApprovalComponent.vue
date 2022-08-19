<template>
    <div>
        <loading :active.sync="isLoading" 
        :can-cancel="false"
        :is-full-page="fullPage"></loading>
        <navbar></navbar>
        <div class="container mt-4 d-print-none">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/acsi_emfs">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Approval form</li>
                </ol>
            </nav>
        </div>
        <div class="container" v-if="(Object.keys(form).length > 0)">
            <div class="row d-none d-print-flex">
                <div class="col-4">
                    <div class="card mt-4 h-100 border-0">
                        <img class="card-img" src="/acsi_emfs/public/images/tsi_acsi_logo.jpg" alt="">
                    </div>
                </div>
                <div class="col-4">
                    <div class="card h-100 mt-4 border-0">
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <h6 class="card-title center-text font-weight-bold">EMPLOYEE MOVEMENT FORM</h6>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card mt-4 h-100 border-0">
                        <img class="card-img" src="/acsi_emfs/public/images/tsi_acsi_logo.jpg" alt="">
                    </div>
                </div>
                <div class="col-12">
                    <h6 class="text-center text-muted">This form shall be used to document changes in the employment details of the employees throughout the employee’s employment in the organization.</h6>
                    <h6 class="text-center text-muted">No movement shall take effect without this document.</h6>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12 mb-2" >
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="form.records[0].remarks != null && form.records[0].status_id == 10">
                        <p class=" text-center">Form cancelled!</p>
                        <p class="font-weight-bold text-center">Remarks: {{form.records[0].remarks}}</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="col-12 mb-2" >
                    <div class="alert alert-warning alert-dismissible fade show" role="alert" v-if="form.records[0].remarks != null && form.records[0].status_id != 10">
                        <p class=" text-center">Form returned!</p>
                        <p class="font-weight-bold text-center">Remarks: {{form.records[0].remarks}}</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="col-12">
                    <table class="table table-bordered table-sm" style="border: 5px solid black">
                        <tbody>
                            <tr>
                                <td class="font-weight-bold ">PERSONAL INFORMATION</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-10">
                            <table class="table table-bordered " >
                                <tbody>
                                    <tr style="border: 2px solid black">
                                        <td>Name: <strong >{{ form.employee.firstname }} {{ form.employee.lastname }}</strong></td>
                                    </tr>
                                    <tr style="border: 2px solid black">
                                        <td>Employee ID: <strong>{{ form.employee.empno }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-2" v-if="Object.keys(selected_employee).length > 0">
                            <img :src="'http://tsi-acsi1.webhop.biz'+selected_employee.info1.emp_pic.picloc" alt="employee image" height="94px">
                        </div>
                    </div>
                </div>
                
                <div class="col-12">
                    <table class="table table-bordered table-sm" style="border: 5px solid black">
                        <tbody>
                            <tr>
                                <td class="font-weight-bold ">MOVEMENT DETAILS</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 col-md-4">
                    <table class="table table-bordered table-sm table-striped">
                        <tbody>
                            <tr style="border: 2px solid black">
                                <td class="font-weight-bold text-center">MOVEMENT</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="position_title"  @click.prevent="" :checked="form.move_position">
                                        <label class="custom-control-label" for="position_title">POSITION TITLE</label>
                                    </div>
                                </td>
                            </tr>
                            <tr >
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="job_status" @click.prevent="" :checked="form.move_job_status">
                                        <label class="custom-control-label" for="job_status">JOB STATUS</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="job_level" @click.prevent="" :checked="form.move_job_level">
                                        <label class="custom-control-label" for="job_level">JOB LEVEL</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="role" @click.prevent="" :checked="form.move_role">
                                        <label class="custom-control-label" for="role">ROLE ASSIGNMENT</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="department" @click.prevent="" :checked="form.move_department">
                                        <label class="custom-control-label" for="department">DEPARTMENT</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="cost_center" @click.prevent="" :checked="form.move_cost_center">
                                        <label class="custom-control-label" for="cost_center">COST CENTER</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="salary" @click.prevent="" :checked="form.move_salary">
                                        <label class="custom-control-label" for="salary">SALARY</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="allowance" @click.prevent="" :checked="form.move_allowance">
                                        <label class="custom-control-label" for="allowance">MONTHLY ALLOWANCE</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="immediate_superior" @click.prevent="" :checked="form.move_immediate_superior">
                                        <label class="custom-control-label" for="immediate_superior">IMMEDIATE SUPERIOR</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="department_manager" @click.prevent="" :checked="form.move_manager">
                                        <label class="custom-control-label" for="department_manager">DEPARTMENT MANAGER</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="extion_of_contract" @click.prevent="" :checked="form.move_contract">
                                        <label class="custom-control-label" for="extion_of_contract">EXTENSION OF CONTRACT</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="others" @click.prevent="" :checked="form.move_others">
                                        <label class="custom-control-label" for="others">OTHERS</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class=" d-print-none">
                                <td class="text-center font-weight-bold">Reason for transfer:</td>
                            </tr>
                            <tr>
                                <td class="text-center font-weight-bold">Effectivity date:</td>
                            </tr>
                            <tr>
                                <td class="text-center font-weight-bold">Created By:</td>
                            </tr>
                            <tr>
                                <td class="text-center font-weight-bold">Date created:</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 col-md-8">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <table class="table table-sm table-bordered w-100 text-center font-weight-bold table-striped">
                                <tbody>
                                    <tr style="border: 2px solid black">
                                        <td >FROM</td>
                                    </tr>
                                    <tr>
                                        <td>{{ form.from_position}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ form.from_job_status }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ form.from_job_level }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ form.from_role }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ form.from_department }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ form.from_cost_center }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ form.from_salary == null ? 0 :  form.from_salary}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{form.allowance == null ? 0 :  form.allowance}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ form.current_superior.firstname}} {{ form.current_superior.lastname}}</td>
                                    </tr>
                                    <tr>
                                        <td >{{form.current_manager.firstname}}  {{form.current_manager.lastname}}</td>
                                    </tr>
                                    <tr>
                                        <td >{{ form.from_contract == null ? 'N/A' : form.from_contract }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ form.from_others == null ? 'N/A' : form.from_others }}</td>
                                    </tr>
                                    <tr class=" d-print-none">
                                        <td>{{form.reason_for_movement == null ? 'N/A' : form.reason_for_movement}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{form.effectivity_date}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{form.requestor.firstname}} {{form.requestor.lastname}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{form.created_at}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 col-md-6">
                            <table class="table table-sm table-bordered w-100 text-center font-weight-bold table-striped">
                                <tbody>
                                    <tr style="border: 2px solid black">
                                        <td >TO</td>
                                    </tr>
                                    <tr>
                                        <td>{{form.to_position == null ? 'SAME' : form.to_position}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{form.to_job_status == null ? 'SAME' : form.to_job_status}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{form.to_job_level == null ? 'SAME' : form.to_job_level}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{form.to_role == null ? 'SAME' : form.to_role}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{form.to_cost_center == null ? 'SAME' : form.to_department}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{form.to_cost_center == null ? 'SAME' : form.to_cost_center}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{form.to_salary == null ? 'SAME' : form.to_salary}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{form.to_allowance == null ? 'SAME' : form.to_allowance}}</td>
                                    </tr>
                                    <tr>
                                        <td v-if="form.to_immediate_superior != null">{{form.new_superior.firstname}} {{form.new_superior.lastname}}</td>
                                        <td v-else>SAME</td>
                                    </tr>
                                    <tr>
                                        <td v-if="form.to_manager != null">{{form.new_manager.firstname}} {{form.new_manager.lastname}}</td>
                                        <td v-else>SAME</td>
                                    </tr>
                                    <tr>
                                        <td>{{form.to_contract == null ? 'SAME' : form.to_contract}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{form.to_others == null ? 'SAME' : form.to_others}}</td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <table class="table table-borderless table-sm" >
                        <tbody>
                            <tr style="border: 5px solid black">
                                <td class="font-weight-bold " colspan="2">APPROVAL</td>
                            </tr>
                            <tr>
                                <td style='font-weight: bold;' class="border-0 w-50"  >
                                    <br>
                                    <br>
                                    <div class="text-center mt-5">
                                        <img src="/acsi_emfs/public/images/approved.png"  height="50" class="d-inline-block align-top" alt="" loading="lazy" v-if="form.superior_accept_date != null"><br>
                                        <small  v-if="form.superior_accept_date != null" class="align-middle">Date approved: {{form.superior_accept_date}}</small>
                                        <div v-if="form.records[0].status_id == 1 && current_user.empno == form.current_superior.empno" class="row">
                                            <div class="col-12 col-md-6">
                                                <button data-toggle="modal" data-target="#approveModal" class="btn btn-success w-100" >Approve <i class="fa-solid fa-check"></i></button>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <button data-toggle="modal" data-target="#cancelModal" class="btn btn-danger w-100" >Cancel <i class="fa-solid fa-xmark"></i></button>
                                            </div>
                                        </div>
                                        
                                        <h6 class="align-middle font-weight-bold">{{form.current_superior.firstname}}  {{form.current_superior.lastname}}</h6>
                                        <h6 class="align-middle font-weight-bold">{{ form.current_superior.info1.eposition }}</h6>
                                    </div>
                                </td>
                                <td style='font-weight: bold;' class="border-0 w-50">
                                    <br>
                                    <br>
                                    <div class="text-center mt-5">
                                        <img src="/acsi_emfs/public/images/approved.png"  height="50" class="d-inline-block align-top" alt="" loading="lazy" v-if="form.manager_accept_date != null"><br>
                                        <small  v-if="form.manager_accept_date != null" class="align-middle">Date approved: {{form.manager_accept_date}}</small>
                                        <div v-if="form.records[0].status_id == 2 && current_user.empno == form.current_manager.empno" class="row">
                                            <div class="col-12 col-md-6">
                                                <button data-toggle="modal" data-target="#approveModal" class="btn btn-success w-100" >Approve <i class="fa-solid fa-check"></i></button>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <button data-toggle="modal" data-target="#cancelModal" class="btn btn-danger w-100" >Cancel <i class="fa-solid fa-xmark"></i></button>
                                            </div>
                                        </div>
                                        <h6 class="align-middle font-weight-bold">{{form.current_manager.firstname}}  {{form.current_manager.lastname}}</h6>
                                        <h6 class="align-middle font-weight-bold">{{ form.current_manager.info1.eposition }}</h6>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style='font-weight: bold;' class="border-0 w-50" v-if="form.to_manager != null">
                                    <br>
                                    <br>
                                    <div class="text-center mt-5" v-if="form.from_manager != form.to_manager && form.to_manager != 'ACSI-200634'">
                                        <img src="/acsi_emfs/public/images/approved.png"  height="50" class="d-inline-block align-top" alt="approve image" loading="lazy" v-if="form.new_manager_accept_date != null"><br>
                                        <small  v-if="form.new_manager_accept_date != null" class="align-middle">Date approved: {{form.new_manager_accept_date}}</small>
                                        <div v-if="form.records[0].status_id == 4 && current_user.empno == form.new_manager.empno" class="row">
                                            <div class="col-12 col-md-6">
                                                <button data-toggle="modal" data-target="#approveModal" class="btn btn-success w-100" >Approve <i class="fa-solid fa-check"></i></button>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <button data-toggle="modal" data-target="#cancelModal" class="btn btn-danger w-100" >Cancel <i class="fa-solid fa-xmark"></i></button>
                                            </div>
                                        </div>
                                        <h6 class="align-middle font-weight-bold" >{{ form.new_manager.firstname }} {{ form.new_manager.lastname }}</h6>
                                        <h6 class="align-middle font-weight-bold" >{{ form.new_manager.info1.eposition }}</h6>
                                    </div>
                                </td>
                                <td style='font-weight: bold;' class="border-0">
                                    <br>
                                    <br>
                                    <div class="text-center mt-5">
                                        <img src="/acsi_emfs/public/images/approved.png"  height="50" class="d-inline-block align-top" alt="approve image" loading="lazy" v-if="form.cable_head_accept_date != null"><br>
                                        <small v-if="form.cable_head_accept_date != null" class="align-middle">Date approved: {{form.cable_head_accept_date}}</small>
                                        <div v-if="form.records[0].status_id == 5 && current_user.empno == 'ACSI-200634'" class="row">
                                            <div class="col-12 col-md-6">
                                                <button data-toggle="modal" data-target="#approveModal" class="btn btn-success w-100" >Approve <i class="fa-solid fa-check"></i></button>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <button data-toggle="modal" data-target="#cancelModal" class="btn btn-danger w-100" >Cancel <i class="fa-solid fa-xmark"></i></button>
                                            </div>
                                        </div>
                                        <h6 class="align-middle font-weight-bold">Oliver Angeles</h6>
                                        <h6 class="align-middle font-weight-bold">Head, Cable Operations</h6>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <table class="table table-borderless table-sm" >
                        <tbody>
                            <tr style="border: 5px solid black">
                                <td class="font-weight-bold " colspan="2">ACKNOWLEDGED</td>
                            </tr>
                            
                            <tr>
                                <td style='font-weight: bold;' class="border-0 w-50">
                                    <br>
                                    <br>
                                    <div class="text-center mt-5">
                                        <img src="/acsi_emfs/public/images/acknowledge.png"  height="50" class="d-inline-block align-top" alt="" loading="lazy" v-if="form.hr_accept_date != null"><br>
                                        <small v-if="form.hr_accept_date != null" class="align-middle">Date acknowledge: {{form.hr_accept_date}}</small>
                                        <button @click="approved()" class="btn btn-success w-75" v-if="form.records[0].status_id == 6 && current_user.empno == form.hr_account_officer">Acknowledge</button>
                                        <h6 class="align-middle font-weight-bold">{{ form.account_officer.firstname}} {{ form.account_officer.lastname}}</h6>
                                        <h6 class="align-middle font-weight-bold">HR Account Officer</h6>
                                    </div>
                                </td>
                                <td style='font-weight: bold;' class="border-0 w-50"  height='75'>
                                    <!-- <hr class="w-50 mx-auto mt-5"> -->
                                    <br>
                                    <br>
                                    <div class="text-center mt-5">
                                        <img src="/acsi_emfs/public/images/acknowledge.png"  height="50" class="d-inline-block align-top" alt="" loading="lazy" v-if="form.employee_accept_date != null"><br>
                                        <small v-if="form.employee_accept_date != null" class="align-middle">Date acknowledge: {{form.employee_accept_date}}</small>
                                        <button @click="approved()" class="btn btn-success w-75" v-if="form.records[0].status_id == 7 && current_user.empno == form.emp_no">Acknowledge</button>
                                        <h6 class="align-middle font-weight-bold">{{form.employee.firstname}}  {{form.employee.lastname}}</h6>
                                        <h6 class="align-middle font-weight-bold">{{ form.employee.info1.eposition }}</h6>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="col-12 ">
                    <br>
                    <br>
                    <br>
                    <h5>HR Form 011: Employee Movement Formv2</h5>
                </div>
                <div class="fixed-bottom d-flex justify-content-center">
                    <a href="/acsi_emfs" class="btn btn-danger mb-3" >BACK <i class="fa-solid fa-circle-arrow-left"></i></a>
                </div>
            </div>
        </div>
        <!-- Approval Modal -->
        <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approvalConfirmation" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approvalConfirmation">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Do you really want to approve?</h5> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="approved()" data-dismiss="modal">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Return Modal -->
        <div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="approvalConfirmation" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approvalConfirmation">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Do you really want to return to previous approver?</h5>
                        <br>
                        <div class="form-group">
                            <label for="remarks">Remarks:</label>
                            <textarea name="remarks" id="remarks" cols="30" rows="10" class="form-control" v-model="remarks"></textarea>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="returned()" :disabled="remarks == null ? true : false" data-dismiss="modal">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Return Modal -->
        <div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="approvalConfirmation" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approvalConfirmation">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Do you really want to return to previous approver?</h5>
                        <br>
                        <div class="form-group">
                            <label for="remarks">Remarks:</label>
                            <textarea name="remarks" id="remarks" cols="30" rows="10" class="form-control" v-model="remarks"></textarea>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="returned()" :disabled="remarks == null ? true : false" data-dismiss="modal">Yes</button>
                        <button class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- cancel Modal -->
        <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="approvalConfirmation" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approvalConfirmation">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Do you really want to cancel this form?</h5>
                        <br>
                        <div class="form-group">
                            <label for="remarks">Remarks:</label>
                            <textarea name="remarks" id="remarks" cols="30" rows="10" class="form-control" v-model="remarks"></textarea>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="cancel()" :disabled="remarks == null ? true : false" data-dismiss="modal">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
import navbar from './NavbarComponent.vue'
import AppStorage from '../components/Helpers/AppStorage'
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    components:{navbar,Loading},
    data(){
        return{
            isLoading:false,
            fullPage: true,
            form:[],
            employees:[],
            selected_employee: [],
            current_supervisor:[],
            current_manager:[],
            selected_supervisor: [],
            selected_manager: [],
            current_user: [],
            remarks: null
        }
    },
    methods:{
        getForm(){
            axios.get('/acsi_emfs/api/employee-movement-form/'+this.$route.params.request_no).then(response => {
                console.log(response.data)
                this.form = response.data
                this.getUser(response.data.emp_no)
            })
            
            
        },
        getUser(emp_no){
            axios.post('/acsi_emfs/api/employees/'+emp_no).then(response => {
                // console.log(response.data)
                this.selected_employee = response.data
            }).catch(error => console.log(error.response.data))
            
        },
        getCurrentUser(){
            
            axios.post('/acsi_emfs/api/get-current-user').then(response => {
                // console.log(response.data)
                this.current_user = response.data
            })
        },
        approved(){
            this.isLoading = true;
            const fd = new FormData()
            fd.append('request_no',this.$route.params.request_no)
            fd.append('current_status',this.form.records[0].status_id)
            axios.post('/acsi_emfs/api/movement-record',fd).then(response => {
                console.log(response.data)
                if(response.data == 'success'){
                    this.isLoading = false;
                    if(this.form.records[0].status_id == 6 || this.form.records[0].status_id == 7){
                        alert('Movement Acknowledged!')
                    }else{
                        alert('Movement Approved!')
                    }
                    
                    window.location.reload()
                }
            }).catch(error => console.log(error.response.data))
        },
        returned(){
            this.isLoading = true;
            const fd = new FormData()
            fd.append('request_no',this.$route.params.request_no)
            fd.append('remarks',this.remarks)
            axios.post('/acsi_emfs/api/return-emf',fd).then(response => {
                console.log(response.data)
                if(response.data == 'success'){
                    this.isLoading = false;
                    alert('Movement returned!')
                    window.location.reload()
                }
            }).catch(error => console.log(error.response.data))
        },
        cancel(){
            this.isLoading = true;
            const fd = new FormData()
            fd.append('request_no',this.$route.params.request_no)
            fd.append('remarks',this.remarks)
            axios.post('/acsi_emfs/api/cancel-emf',fd).then(response => {
                console.log(response.data)
                if(response.data == 'success'){
                    this.isLoading = false;
                    alert('Movement cancelled!')
                    window.location.reload()
                }
            }).catch(error => console.log(error.response.data))
        }
    },
    created(){
        if(AppStorage.getToken()){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + AppStorage.getToken()
        }
        this.getForm()
        this.getCurrentUser()

    }
}
</script>

<style>
    @media print {
        html {
            zoom: 83%;
        }
    }
</style>