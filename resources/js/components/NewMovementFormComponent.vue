<template>
    <div>
        <navbar></navbar>
        <div class="container mt-4 d-print-none">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/acsi_emfs">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">New movement form</li>
                </ol>
            </nav>
            <div class="input-group ">
                <input placeholder="Type employee name here ..." class="form-control" @change="search($event.target)" id="searchbox" list="" @keyup="searchUpdate()" @keyup.enter="searchUpdate()">
                <datalist id="employees">
                    <option v-for="(employee,index) in employees" :key="index"  :value="employee.empno">{{employee.firstname}} {{employee.middlename != null ? employee.middlename : ''}}  {{employee.lastname}} {{employee.servarea != 'N/A' ? 'of ' + employee.servarea : ''}}</option>
                </datalist>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button" id="button-addon2" @click="search(selected_employee)" :disabled="selected_employee.length == 0 ? true : false"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
        </div>
        <div class="container">
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
                <!-- <div class="col-12" v-if="Object.keys(selected_employee).length > 0">
                    <div class="row">
                        <div class="col-3">
                            <img :src="'http://tsi-acsi1.webhop.biz'+selected_employee.info1.emp_pic.picloc" alt="employee image" class="img-thumbnail">
                        </div>
                    </div>
                </div> -->
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
                                        <td>Name: <strong >{{selected_employee.length == 0 ?  'N/A' : selected_employee.firstname}} {{selected_employee.middlename != null ? selected_employee.middlename : ''}}  {{selected_employee.lastname}}</strong></td>
                                    </tr>
                                    <tr style="border: 2px solid black">
                                        <td>Employee ID: <strong >{{selected_employee.empno == null ? 'N/A' : selected_employee.empno}}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- <div class="col-12 col-md-7">
                            <table class="table table-bordered ">
                                <tbody>
                                    <tr style="border: 2px solid black">
                                        <td class="font-weight-bold text-center">{{selected_employee.length == 0 ?  'N/A' : selected_employee.firstname}} {{selected_employee.middlename != null ? selected_employee.middlename : ''}}  {{selected_employee.lastname}}</td>
                                    </tr>
                                    <tr style="border: 2px solid black">
                                        <td class="font-weight-bold text-center">{{selected_employee.empno == null ? 'N/A' : selected_employee.empno}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> -->
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
                                        <input type="checkbox" class="custom-control-input" id="position_title" v-model="position_toggler" :disabled="current_user.position == 'hr_officer' ? false : true">
                                        <label class="custom-control-label" for="position_title">POSITION TITLE</label>
                                    </div>
                                </td>
                            </tr>
                            <tr >
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="job_status" v-model="job_status_toggler" :disabled="current_user.position == 'hr_officer' ? false : true">
                                        <label class="custom-control-label" for="job_status">JOB STATUS</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="job_level" v-model="job_level_toggler" :disabled="current_user.position == 'hr_officer' ? false : true">
                                        <label class="custom-control-label" for="job_level">JOB LEVEL</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="role" v-model="role_toggler">
                                        <label class="custom-control-label" for="role">ROLE ASSIGNMENT</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="department" v-model="departments_toggler">
                                        <label class="custom-control-label" for="department">DEPARTMENT</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="cost_center" v-model="cost_toggler">
                                        <label class="custom-control-label" for="cost_center">COST CENTER</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="salary" v-model="salary_toggler" :disabled="current_user.position == 'hr_officer'  ? false : true">
                                        <label class="custom-control-label" for="salary">SALARY</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="allowance" v-model="allowance_toggler">
                                        <label class="custom-control-label" for="allowance">MONTHLY ALLOWANCE</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="immediate_superior" v-model="supervisor_toggler" @change="checkSupervisorToggler($event)">
                                        <label class="custom-control-label" for="immediate_superior">IMMEDIATE SUPERIOR</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="department_manager" v-model="manager_toggler" :disabled="current_user.position == 'hr_officer'  ? false : true">
                                        <label class="custom-control-label" for="department_manager">DEPARTMENT MANAGER</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="extion_of_contract" v-model="extension_toggler" :disabled="current_user.position == 'hr_officer'  ? false : true">
                                        <label class="custom-control-label" for="extion_of_contract">EXTENSION OF CONTRACT</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="others" v-model="other_toggler" :disabled="current_user.position == 'hr_officer'  ? false : true">
                                        <label class="custom-control-label" for="others">OTHERS</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class=" d-print-none">
                                <td class="text-center font-weight-bold">Reason for movement:</td>
                            </tr>
                            <tr>
                                <td class="text-center font-weight-bold">Effectivity date:</td>
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
                                        <td>{{ selected_employee.length == 0 ?  'N/A' : selected_employee.info1.eposition }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ selected_employee.length == 0 ?  'N/A' : selected_employee.info1.estatus }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ selected_employee.length == 0 ?  'N/A' : selected_employee.info1.elevel }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ selected_employee.length == 0 ?  'N/A' : selected_employee.info1.erole }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ selected_employee.length == 0 ?  'N/A' : selected_employee.info1.ecurrdept }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ selected_employee.length == 0 ?  'N/A' : selected_employee.info1.ecostcenter }}</td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="salary" id="salary" v-model="from_salary" class="border-0 text-center h-100"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="allowance" id="allowance" v-model="from_allowance" class="border-0 text-center h-100"></td>
                                    </tr>
                                    <tr>
                                        <td v-if="selected_employee.length == 0 || selected_employee.info1.supervisor.length == 0">N/A</td>
                                        <td v-else>{{selected_employee.info1.supervisor.firstname}}  {{selected_employee.info1.supervisor.lastname}}</td>
                                    </tr>
                                    <tr>
                                        <td v-if="selected_employee.length == 0 || selected_employee.info1.manager.length == 0">N/A</td>
                                        <td v-else>{{selected_employee.info1.manager.firstname}}  {{selected_employee.info1.manager.lastname}}</td>
                                    </tr>
                                    <tr>
                                        <td v-if="extension_toggler == false">N/A</td>
                                        <td v-else>
                                            <input type="date" name="eoc" id="eoc"  class="border-0 text-center" v-model="from_contract">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="other_toggler == false">N/A</td>
                                        <td v-else>
                                            <input type="text" name="other" id="other" class="border-0 text-center h-100" v-model="from_others">
                                        </td>
                                    </tr>
                                    <tr class=" d-print-none">
                                        <td>
                                            <input type="text" name="reason_for_transfer" id="reason_for_transfer" class="h-100 border-0 w-100" v-model="reason">
                                             <small class="text-danger" v-if="errors.reason_for_movement">*This field is required!</small>
                                        </td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="date" name="effective_date" id="effective_date" class="text-center border-0 h-100 w-100" v-model="effectivity_date">
                                            <small class="text-danger" v-if="errors.effectivity_date">*This field is required!</small>
                                        </td>
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
                                        <td v-if="position_toggler == false">SAME</td>
                                        <td v-if="position_toggler == true">
                                            <select name="position_title" id="position_title" class="border-0 w-100 text-center" v-model="selected_position" :disabled="current_user.position == 'hr_officer' ? false : true">
                                                <option v-for="(position,index) in positions" :key="index" i :value="position.eposition" >{{position.eposition}}</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.to_position">*This field is required!</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="job_status_toggler == false">SAME</td>
                                        <td v-if="job_status_toggler == true">
                                            <select name="job_status" id="job_status" class="border-0 w-100 text-center" v-model="selected_status" :disabled="current_user.position == 'hr_officer' ? false : true">
                                                <option value="Probationary">Probationary</option>
                                                <option value="Regular">Regular</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.to_job_status">*This field is required!</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="job_level_toggler == false">SAME</td>
                                        <td v-if="job_level_toggler == true">
                                            <select name="job_level" id="job_level" class="border-0 w-100 text-center" v-model="selected_level" :disabled="current_user.position == 'hr_officer' ? false : true">
                                                <option v-for="(job_level,index) in job_level" :key="index" :value="job_level.job_name">{{job_level.job_name}}</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.to_job_level">*This field is required!</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="role_toggler == false">SAME</td>
                                        <td v-if="role_toggler == true">
                                            <select name="role" id="role" class="border-0 w-100 text-center" v-model="selected_role" >
                                                <option value="">N/A</option>
                                                <option v-for="(role,index) in roles" :key="index" :value="role.role_name">{{role.role_name}}</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.to_role">*This field is required!</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="departments_toggler == false">SAME</td>
                                        <td v-if="departments_toggler == true">
                                            <select name="department" id="department" class="border-0 w-100 text-center" v-model="selected_department" @change="departmentUpdate()">
                                                <option v-for="(cost_center,index) in cost_centers" :key="index" :value="cost_center.ccname" :selected="cost_center.ccname == selected_cost_center ? true : false">{{cost_center.ccname}}</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.to_department">*This field is required!</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="cost_toggler == false">SAME</td>
                                        <td v-if="cost_toggler == true">
                                            <select name="cost_center" id="cost_center" class="border-0 w-100 text-center" v-model="selected_cost_center">
                                                <option v-for="(cost_center,index) in cost_centers" :key="index" :value="cost_center.ccname" :selected="cost_center.ccname == selected_cost_center ? true : false">{{cost_center.ccname}}</option>
                                            </select>
                                           <small class="text-danger" v-if="errors.to_cost_center">*This field is required!</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="salary_toggler == false">SAME</td>
                                        <input v-else type="text" name="to_salary" id="to_salary" v-model="to_salary" class="border-0 text-center h-100" :disabled="current_user.position == 'hr_officer' ? false : true">
                                    </tr>
                                    <tr>
                                        <td v-if="allowance_toggler == false">SAME</td>
                                        <td v-else>
                                            <input  type="text" name="to_allowance" id="to_allowance" v-model="to_allowance" class="border-0 text-center h-100" >
                                            <small class="text-danger" v-if="errors.to_allowance">*This field is required!</small>
                                        </td> 
                                    </tr>
                                    <tr>
                                        <td v-if="supervisor_toggler == false">SAME</td>
                                        <td v-if="supervisor_toggler == true">
                                            <select name="supervisor" id="supervisor" class="border-0 w-100 text-center" v-model="selected_supervisor.empno" @change="supervisorUpdate($event.target.value)" >
                                                <option v-for="(supervisor,index) in supervisors" :key="index" :value="supervisor.empno" >{{supervisor.user.firstname}} {{supervisor.user.lastname}}</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.to_immediate_superior">*This field is required!</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="manager_toggler == false">SAME</td>
                                        <td v-if="manager_toggler == true">
                                            <select name="manager" id="manager" class="border-0 w-100 text-center" v-model="selected_manager" :disabled="current_user.position == 'hr_officer' ? false : true">
                                                <option v-for="(manager,index) in managers" :key="index" :value="manager.empno" :selected="selected_manager == manager.empno ? true : false">{{manager.user.firstname}} {{manager.user.lastname}}</option>
                                            </select>
                                            <small class="text-danger" v-if="errors.to_manager">*This field is required!</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="extension_toggler == false">SAME</td>
                                        <td v-else><input type="date" name="eoc" id="eoc"  class="border-0 text-center" v-model="to_contract" :min="new Date().toISOString().slice(0, -14)"></td>
                                    </tr>
                                    <tr>
                                        <td v-if="other_toggler == false">SAME</td>
                                        <td v-else><input type="text" name="to_other" id="to_other" class="border-0 text-center h-100" v-model="to_others"></td>
                                    </tr>
                                    <tr class=" d-print-none">
                                        <td class="h-100 text-white">SAME</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <button class="btn btn-primary w-100" data-toggle="modal" data-target="#submitModal" :disabled="Object.keys(selected_employee).length > 0 ? false : true">Submit</button>
                                        </td>
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
                            <tr v-if="Object.keys(selected_employee).length != 0">
                                <td style='font-weight: bold;' class="border-0 w-50"  v-if="Object.keys(selected_employee.info1.supervisor).length > 0">
                                    <br>
                                    <br>
                                    <div class="text-center mt-5">
                                        <h6 class="align-middle font-weight-bold">{{selected_employee.info1.supervisor.firstname}}  {{selected_employee.info1.supervisor.lastname}}</h6>
                                        <h6 class="align-middle font-weight-bold">{{ selected_employee.info1.supervisor.info1.eposition }}</h6>
                                    </div>
                                </td>
                                <td style='font-weight: bold;' class="border-0 w-50">
                                    <br>
                                    <br>
                                    <div class="text-center mt-5">
                                        <h6 class="align-middle font-weight-bold">{{selected_employee.info1.manager.firstname}}  {{selected_employee.info1.manager.lastname}}</h6>
                                        <h6 class="align-middle font-weight-bold">{{ selected_employee.info1.manager.info1.eposition }}</h6>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="selected_employee != 0">
                                <td style='font-weight: bold;' class="border-0 w-50" v-if="Object.keys(selected_supervisor).length > 0">
                                    <br>
                                    <br>
                                    <div class="text-center mt-5" v-if="selected_supervisor.info1.supervisor.empno !== selected_employee.info1.manager.empno || selected_supervisor.info1.supervisor.empno === 'ACSI-200634'">
                                        <h6 class="align-middle font-weight-bold" v-if="Object.keys(this.selected_supervisor).length">{{ this.selected_supervisor.info1.supervisor.firstname }} {{ this.selected_supervisor.info1.supervisor.lastname }}</h6>
                                        <h6 class="align-middle font-weight-bold" v-if="Object.keys(this.selected_supervisor).length">{{ this.selected_supervisor.info1.supervisor.info1.eposition }}</h6>
                                    </div>
                                </td>
                                <td style='font-weight: bold;' class="border-0">
                                    <br>
                                    <br>
                                    <div class="text-center mt-5">
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
                            
                            <tr v-if="selected_employee != 0" >
                                <td style='font-weight: bold;' class="border-0 w-50">
                                    <br>
                                    <br>
                                    <div class="text-center mt-5">
                                        <h6 class="align-middle font-weight-bold">___________________</h6>
                                        <h6 class="align-middle font-weight-bold">HR Account Officer</h6>
                                    </div>
                                </td>
                                <td style='font-weight: bold;' class="border-0 w-50"  v-if="Object.keys(selected_employee.info1.supervisor).length > 0" height='75'>
                                    <!-- <hr class="w-50 mx-auto mt-5"> -->
                                    <br>
                                    <br>
                                    <div class="text-center mt-5">
                                        <h6 class="align-middle font-weight-bold">{{selected_employee.firstname}}  {{selected_employee.lastname}}</h6>
                                        <h6 class="align-middle font-weight-bold">{{ selected_employee.info1.eposition }}</h6>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
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
        <!-- submit Modal -->
        <div class="modal fade" id="submitModal" tabindex="-1" role="dialog" aria-labelledby="approvalConfirmation" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approvalConfirmation">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Do you really want to submit this form?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="submit()">Yes</button>
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
export default {
    components:{navbar},
    data(){
        return{
            employees:[],
            selected_employee: [],
            
            positions:[
                {eposition: 'Field Service Technician'},
                {eposition: 'HR Account Officer'},
                {eposition: 'HR Assistant'},
                {eposition: 'HR Specialist'},
                {eposition: 'Supervisor'},
                {eposition: 'Quality Assurance'},
                {eposition: 'Warehouse'},
                {eposition: 'Admin Assistant'},
                {eposition: 'Warehouse Custodian'},
                {eposition: 'Associate Programmer'},
                {eposition: 'Liason Assistant'},
                {eposition: 'Jr Finance Officer'},
                {eposition: 'General Facilities Assistant'}
            ],
            
            job_status: [],
            
            job_level:[{job_name:'Managerial'},{job_name:'Supervisor'},{job_name:'Technical Specialist'},{job_name:'Assistant Manager'},{job_name:'Rank & File'}],
            current_user:[],
            roles: [{role_name:'Team leader'},{role_name:'Buddy'}],
            managers:[],
            departments:[],
            supervisors:[],
            cost_centers: [
                {DEPTNAME:'TSI'},
                {DEPTNAME: 'Area 3'},
                {DEPTNAME: 'Area 6'},
                {DEPTNAME: 'Cable admin'},
                {DEPTNAME: 'Cable operations'},
                {DEPTNAME: 'Quality Assurance'},
                {DEPTNAME: 'Area 4'},
                {DEPTNAME: 'Tier 2'}
            ],
            position_toggler: false,
            job_status_toggler: false,
            job_level_toggler: false,
            departments_toggler: false,
            cost_toggler: false,
            role_toggler: false,
            supervisor_toggler: false,
            manager_toggler: false,
            salary_toggler: false,
            allowance_toggler: false,
            extension_toggler: false,
            other_toggler:false,
            selected_position: [],
            selected_status: [],
            selected_level: [],
            selected_role: [],
            selected_department: [],
            selected_cost_center: [],
            selected_supervisor: [],
            selected_manager: [],
            
            effectivity_date: '',
            
            reason:[],
            from_salary: 0,
            to_salary: 0,
            from_allowance: 0,
            to_allowance:0,
            from_contract: new Date().toISOString().slice(0, -14),
            to_contract: new Date().toISOString().slice(0, -14),
            from_others: null,
            to_others:null,
            errors: []
        }
    },
    methods:{
        getUsers(){
            axios.post('/acsi_emfs/api/employees').then(response => {
                // console.log(response.data)
                this.employees = response.data
            }).catch(error => console.log(error.response.data))
        },
        search(e){
            if(e.value != ''){
                this.getUser(e.value)
            }
            
        },
        getUser(emp_no){
            this.clearField()
            axios.post('/acsi_emfs/api/employees/'+emp_no).then(response => {
                // console.log(response.data)
                this.selected_employee = response.data
                this.supervisor_toggler = true
                this.supervisorUpdate(this.current_user.empno)
                if(response.date != ''){
                    $("#searchbox").attr("list","")
                    $("#searchbox").val(this.selected_employee.firstname + ' ' + this.selected_employee.middlename + ' ' + this.selected_employee.lastname ) 
                }
            }).catch(error => console.log(error.response.data))
        },
        getPositions(){
            axios.post('/acsi_emfs/api/positions').then(response => this.positions = response.data)
        },
        getDepartments(){
            axios.post('/acsi_emfs/api/departments').then(response => {
                this.departments = response.data
            })
        },
        getCostCenter(){
            axios.post('/acsi_emfs/api/cost-center').then(response => this.cost_centers = response.data)
        },
        getSupervisor(){
            axios.post('/acsi_emfs/api/supervisor').then(response => {
                // console.log(response.data)
                this.supervisors = response.data
            }).catch(error => console.log(error.response.data))
        },
        getManager(){
            axios.post('/acsi_emfs/api/manager').then(response => {
                this.managers = response.data
            } ).catch(error => console.log(error.response.data))
        },
        supervisorUpdate(e){
            axios.post('/acsi_emfs/api/supervisor/'+e).then(response => {
                // console.log(response.data)
                this.selected_supervisor = response.data
                this.selected_manager = response.data.info1.esup
                this.manager_toggler = true
                this.cost_toggler = true
                this.departments_toggler = true

                this.selected_cost_center = response.data.info1.ecostcenter
                this.selected_department = response.data.info1.ecurrdept
            }).catch(error => console.log(error.response.data))
        },
        checkSupervisorToggler(e){
            console.log(e.target.checked)
            if(e.target.checked == false){
                this.departments_toggler = false
                this.cost_toggler = false
                this.manager_toggler = false
                this.selected_supervisor = []
            }
        },
        searchUpdate(){
            if($("#searchbox").val() != ''){
                $("#searchbox").attr("list","employees")
            }else{
                $("#searchbox").attr("list","")
                this.clearField()
            }
            // if($("#searchbox").val("list","employees")){

            // }
            // $("#searchbox").attr("list","employees");
        },
        getCurrentUser(){
            if(AppStorage.getToken()){
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + AppStorage.getToken()
            }
            axios.post('/acsi_emfs/api/get-current-user').then(response => {
                console.log(response.data)
                this.current_user = response.data
            })
        },
        submit(){
            let fd = new FormData()
            fd.append('emp_no',this.selected_employee.empno)
            fd.append('request_by',this.current_user.empno)
            fd.append('from_position',this.selected_employee.info1.eposition)
            fd.append('from_job_status',this.selected_employee.info1.estatus)
            fd.append('from_job_level',this.selected_employee.info1.elevel)
            fd.append('from_role',this.selected_employee.info1.erole)
            fd.append('from_department',this.selected_employee.info1.ecurrdept)
            fd.append('from_cost_center',this.selected_employee.info1.ecostcenter)
            fd.append('from_salary',this.from_salary)
            fd.append('from_allowance',this.from_allowance)
            fd.append('from_immediate_superior',this.selected_employee.info1.esup)
            fd.append('from_manager',this.selected_employee.info1.emngr)
            fd.append('from_others',this.from_others == null ? '' : this.from_others)
            fd.append('from_contract',this.from_contract)

            fd.append('move_position',this.position_toggler)
            fd.append('move_job_status',this.job_status_toggler)
            fd.append('move_job_level',this.job_level_toggler)
            fd.append('move_role',this.role_toggler)
            fd.append('move_department',this.departments_toggler)
            fd.append('move_cost_center',this.cost_toggler)
            fd.append('move_salary',this.salary_toggler)
            fd.append('move_allowance',this.allowance_toggler)
            fd.append('move_immediate_superior',this.supervisor_toggler)
            fd.append('move_manager',this.manager_toggler)
            fd.append('move_contract',this.extension_toggler)
            fd.append('move_others',this.other_toggler)

            fd.append('to_position',this.selected_position)
            fd.append('to_job_status',this.selected_status)
            fd.append('to_job_level',this.selected_level)
            fd.append('to_role',this.selected_role)
            fd.append('to_department',this.selected_department)
            fd.append('to_cost_center',this.selected_cost_center)
            fd.append('to_salary',this.to_salary)
            fd.append('to_allowance',this.to_allowance)
            fd.append('to_immediate_superior',Object.keys(this.selected_supervisor).length > 0 ? this.selected_supervisor.empno : '')
            
            fd.append('to_manager',Object.keys(this.selected_supervisor).length > 0 ?  this.selected_supervisor.info1.supervisor.empno : '')
            fd.append('to_contract',this.to_contract)
            fd.append('to_others',this.to_others == null ? '' : this.to_others)
            fd.append('reason_for_movement',this.reason)
            fd.append('effectivity_date',this.effectivity_date)
            axios.post('/acsi_emfs/api/employee-movement-form',fd).then(response => {
                console.log(response)
                this.errors = []
                if(response.data == 'success'){
                    this.clearField()
                    $("#searchbox").val('')
                    alert('Movement request done !')
                    location.reload()
                }else if(response.data.errors){
                    $('#submitModal').hide();
                    alert('Fill up all required field!')
                    this.errors = response.data.errors
                }
            }).catch(error => console.log(error.response.data))
        },
        clearField(){
            this.errors = []
            this.selected_employee  = []
            this.position_toggler =  false
            this.job_status_toggler =  false
            this.job_level_toggler =  false
            this.departments_toggler =  false
            this.cost_toggler =  false
            this.role_toggler =  false
            this.supervisor_toggler =  false
            this.manager_toggler =  false
            this.salary_toggler =  false
            this.allowance_toggler =  false
            this.extension_toggler =  false
            this.other_toggler = false
            this.selected_position =  []
            this.selected_status =  []
            this.selected_level =  []
            this.selected_role =  []
            this.selected_department =  []
            this.selected_cost_center =  []
            this.selected_supervisor =  []
            this.selected_manager =  []
            this.effectivity_date =  ''
            
            this.reason = []
            this.from_allowance =  0
            this.to_allowance = 0
        }
    },
    created(){
        this.getCurrentUser()
        this.getUsers()
        this.getPositions()
        this.getDepartments()
        this.getCostCenter()
        this.getSupervisor()
        this.getManager()
        
        
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