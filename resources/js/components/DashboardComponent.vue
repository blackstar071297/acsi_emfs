<template>
    <div>
        <navbar></navbar>
        <div class="container mt-4 d-print-none">
            <div class="input-group ">
                <input list="employees" placeholder="Type employee name here ..." class="form-control" @change="search($event.target.value)" id="searchbox">
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
                        <div class="col-3">
                            <table class="table table-bordered table-sm " >
                                <tbody>
                                    <tr style="border: 2px solid black">
                                        <td>Name:</td>
                                    </tr>
                                    <tr style="border: 2px solid black">
                                        <td>Employee ID:</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-9">
                            <table class="table table-bordered table-sm">
                                <tbody>
                                    <tr style="border: 2px solid black">
                                        <td class="font-weight-bold text-center">{{selected_employee.length == 0 ?  'N/A' : selected_employee.firstname}} {{selected_employee.middlename != null ? selected_employee.middlename : ''}}  {{selected_employee.lastname}}</td>
                                    </tr>
                                    <tr style="border: 2px solid black">
                                        <td class="font-weight-bold text-center">{{selected_employee.empno == null ? 'N/A' : selected_employee.empno}}</td>
                                    </tr>
                                </tbody>
                            </table>
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
                <div class="col-4">
                    <table class="table table-borderless border-0 table-sm">
                        <tbody class="border-0">
                            <tr style="border: 2px solid black">
                                <td class="font-weight-bold text-center">MOVEMENT</td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="position_title" v-model="position_toggler">
                                        <label class="custom-control-label" for="position_title">POSITION TITLE</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="job_status" v-model="job_status_toggler">
                                        <label class="custom-control-label" for="job_status">JOB STATUS</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="job_level" v-model="job_level_toggler">
                                        <label class="custom-control-label" for="job_level">JOB LEVEL</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="role" v-model="role_toggler">
                                        <label class="custom-control-label" for="role">ROLE ASSIGNMENT</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="department" v-model="departments_toggler">
                                        <label class="custom-control-label" for="department">DEPARTMENT</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="cost_center" v-model="cost_toggler">
                                        <label class="custom-control-label" for="cost_center">COST CENTER</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="salary" v-model="salary_toggler">
                                        <label class="custom-control-label" for="salary">SALARY</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="allowance" v-model="allowance_toggler">
                                        <label class="custom-control-label" for="allowance">MONTHLY ALLOWANCE</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="immediate_superior" v-model="supervisor_toggler">
                                        <label class="custom-control-label" for="immediate_superior">IMMEDIATE SUPERIOR</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="department_manager" v-model="manager_toggler">
                                        <label class="custom-control-label" for="department_manager">DEPARTMENT MANAGER</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="extion_of_contract" v-model="extension_toggler">
                                        <label class="custom-control-label" for="extion_of_contract">EXTENSION OF CONTRACT</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="others" v-model="other_toggler">
                                        <label class="custom-control-label" for="others">Others</label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-8">
                    <div class="row">
                        <div class="col-6">
                            <table class="table table-sm table-bordered w-100 text-center font-weight-bold">
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
                                        <td><input type="text" name="salary" id="salary" placeholder="" class="border-0 text-center"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="salary" id="salary" placeholder="" class="border-0 text-center"></td>
                                    </tr>
                                    <tr>
                                        <td v-if="selected_employee.length == 0 || selected_employee.info1.supervisor.length == 0">N/A</td>
                                        <td v-else>{{selected_employee.info1.supervisor.firstname}} {{selected_employee.info1.supervisor.middlename != null ? selected_employee.info1.supervisor.middlename : ''}}  {{selected_employee.info1.supervisor.lastname}}</td>
                                    </tr>
                                    <tr>
                                        <td v-if="selected_employee.length == 0 || selected_employee.info1.manager.length == 0">N/A</td>
                                        <td v-else>{{selected_employee.info1.manager.firstname}} {{selected_employee.info1.manager.middlename != null ? selected_employee.info1.manager.middlename : ''}}  {{selected_employee.info1.manager.lastname}}</td>
                                    </tr>
                                    <tr>
                                        <td v-if="extension_toggler == false">N/A</td>
                                        <td v-else><input type="date" name="eoc" id="eoc"  class="border-0 text-center" ></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="other" id="other"  class="border-0 text-center"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6">
                            <table class="table table-sm table-bordered w-100 text-center font-weight-bold">
                                <tbody>
                                    <tr style="border: 2px solid black">
                                        <td >TO</td>
                                    </tr>
                                    <tr>
                                        <td v-if="position_toggler == false">{{selected_position}}</td>
                                        <td v-if="position_toggler == true">
                                            <select name="position_title" id="position_title" class="border-0 w-100 text-center" v-model="selected_position">
                                                <option v-for="(position,index) in positions" :key="index" i :value="position.eposition" >{{position.eposition}}</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="job_status_toggler == false">{{selected_status}}</td>
                                        <td v-if="job_status_toggler == true">
                                            <select name="job_status" id="job_status" class="border-0 w-100 text-center" v-model="selected_status">
                                                <option value="Probationary">Probationary</option>
                                                <option value="Regular">Regular</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="job_level_toggler == false">{{selected_level}}</td>
                                        <td v-if="job_level_toggler == true">
                                            <select name="job_level" id="job_level" class="border-0 w-100 text-center" v-model="selected_level">
                                                <option v-for="(job_level,index) in job_level" :key="index" :value="job_level.job_name">{{job_level.job_name}}</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="role_toggler == false">{{selected_role}}</td>
                                        <td v-if="role_toggler == true">
                                            <select name="role" id="role" class="border-0 w-100 text-center" v-model="selected_role">
                                                <option value="">N/A</option>
                                                <option v-for="(role,index) in roles" :key="index" :value="role.role_name">{{role.role_name}}</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="departments_toggler == false">{{selected_department}}</td>
                                        <td v-if="departments_toggler == true">
                                            <select name="department" id="department" class="border-0 w-100 text-center" v-model="selected_department" @change="departmentUpdate()">
                                                <option v-for="(department,index) in departments" :key="index" :value="department.ccname">{{department.ccname}}</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="cost_toggler == false">{{selected_cost_center}}</td>
                                        <td v-if="cost_toggler == true">
                                            <select name="cost_center" id="cost_center" class="border-0 w-100 text-center" v-model="selected_cost_center">
                                                <option v-for="(cost_center,index) in cost_centers" :key="index" :value="cost_center.DEPTNAME" :selected="cost_center.DEPTNAME == selected_cost_center ? true : false">{{cost_center.DEPTNAME}}</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="salary_toggler == false">SAME</td>
                                        <input v-else type="text" name="to_salary" id="to_salary" placeholder="" class="border-0 text-center">
                                    </tr>
                                    <tr>
                                        <td v-if="allowance_toggler == false">SAME</td>
                                        <input v-else type="text" name="to_allowance" id="to_allowance" placeholder="" class="border-0 text-center">
                                    </tr>
                                    <tr>
                                        <td v-if="supervisor_toggler == false">{{selected_supervisor}}</td>
                                        <td v-if="supervisor_toggler == true">
                                            <select name="supervisor" id="supervisor" class="border-0 w-100 text-center" v-model="selected_supervisor" @change="supervisorUpdate($event)">
                                                <option v-for="(supervisor,index) in supervisors" :key="index" :value="supervisor.empno" >{{supervisor.user.firstname}} {{supervisor.user.middlename == null ? '' :  supervisor.user.middlename}} {{supervisor.user.lastname}}</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="manager_toggler == false">{{selected_manager}}</td>
                                        <td v-if="manager_toggler == true">
                                            <select name="supervisor" id="supervisor" class="border-0 w-100 text-center" v-model="selected_manager">
                                                <option v-for="(manager,index) in managers" :key="index" :value="manager.empno" :selected="selected_manager == manager.empno ? true : false">{{manager.user.firstname}} {{manager.user.middlename == null ? '' :  manager.user.middlename}} {{manager.user.lastname}}</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>SAME</td>
                                    </tr>
                                    <tr>
                                        <td>SAME</td>
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
                            <tr v-if="selected_employee != 0">
                                <td style='font-weight: bold;' class="border-0"  v-if="Object.keys(selected_employee.info1.supervisor).length > 0">
                                    <hr class="w-50 mx-auto mt-4">
                                    <div class="text-center">
                                        <h6 class="align-middle font-weight-bold">{{selected_employee.info1.supervisor.firstname}} {{selected_employee.info1.supervisor.middlename != null ? selected_employee.info1.supervisor.middlename : ''}}  {{selected_employee.info1.supervisor.lastname}}</h6>
                                        <h6 class="align-middle font-weight-bold">{{ selected_employee.info1.supervisor.info1.eposition }}</h6>
                                    </div>
                                </td>
                                <td style='font-weight: bold;' class="border-0">
                                    <hr class="w-50 mx-auto mt-4">
                                    <div class="text-center">
                                        <h6 class="align-middle font-weight-bold">OLIVER P. ANGELES</h6>
                                        <h6 class="align-middle font-weight-bold">Head, Cable Operations</h6>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="selected_employee != 0">
                                <td style='font-weight: bold;' class="border-0">
                                    <hr class="w-50 mx-auto mt-4">
                                    <div class="text-center">
                                        <h6 class="align-middle font-weight-bold">SUNSHINE N. CUNANAN</h6>
                                        <h6 class="align-middle font-weight-bold">HR Account Officer</h6>
                                    </div>
                                </td>
                                <td style='font-weight: bold;' class="border-0">
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
                            <tr v-if="selected_employee != 0">
                                <td >
                                    <hr class="w-50 mx-auto mt-4">
                                    <div class="text-center">
                                        <h6 class="align-middle font-weight-bold">{{selected_employee.firstname}} {{selected_employee.middlename != null ? selected_employee.middlename : ''}}  {{selected_employee.lastname}}</h6>
                                        <h6 class="align-middle font-weight-bold">{{ selected_employee.info1.eposition }}</h6>
                                    </div>
                                </td>
                                <td>
                                    <hr class=" mx-auto mt-4">
                                    <div class="text-center">
                                        <h6 class="align-middle font-weight-bold">{{ new Date().toLocaleDateString("en-US") }}</h6>
                                        <h6 class="align-middle font-weight-bold">DATE</h6>
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
            </div>
        </div>
    </div>
</template>

<script>
import navbar from './NavbarComponent.vue'
export default {
    components:{navbar},
    data(){
        return{
            employees:[],
            selected_employee: [],
            position_toggler: false,
            positions:[],
            job_status_toggler: false,
            job_status: [],
            job_level_toggler: false,
            job_level:[{job_name:'Managerial'},{job_name:'Supervisor'},{job_name:'Technical Specialist'},{job_name:'Assistant Manager'},{job_name:'Rank & File'}],
            role_toggler: false,
            roles: [{role_name:'Team leader'},{role_name:'Buddy'}],
            departments_toggler: false,
            departments:[],
            cost_toggler: false,
            cost_centers: [],
            supervisor_toggler: false,
            supervisors:[],
            manager_toggler: false,
            managers:[],
            salary_toggler: false,
            allowance_toggler: false,
            extension_toggler: false,
            other_toggler:false,
            selected_position: 'SAME',
            selected_status: 'SAME',
            selected_level: 'SAME',
            selected_role: 'SAME',
            selected_department: 'SAME',
            selected_cost_center: 'SAME',
            selected_supervisor: 'SAME',
            selected_manager: 'SAME',

        }
    },
    methods:{
        getUsers(){
            axios.post('/acsi_emfs/api/employees').then(response => {
                this.employees = response.data
            }).catch(error => console.log(error.response.data))
        },
        search(value){
            this.getUser(value)
        },
        getUser(emp_no){
            axios.post('/acsi_emfs/api/employees/'+emp_no).then(response => {
                this.selected_employee = response.data
            }).catch(error => console.log(error.response.data))
        },
        getPositions(){
            axios.post('/acsi_emfs/api/positions').then(response => this.positions = response.data)
        },
        getDepartments(){
            axios.post('/acsi_emfs/api/cost-center').then(response => {
                this.departments = response.data
            })
        },
        getCostCenter(){
            axios.post('/acsi_emfs/api/departments').then(response => this.cost_centers = response.data)
        },
        getSupervisor(){
            axios.post('/acsi_emfs/api/supervisor').then(response => {
                console.log(response.data)
                this.supervisors = response.data
            }).catch(error => console.log(error.response.data))
        },
        getManager(){
            axios.post('/acsi_emfs/api/manager').then(response => this.managers = response.data ).catch(error => console.log(error.response.data))
        },
        supervisorUpdate(e){
            axios.post('/acsi_emfs/api/employees/'+e.target.value).then(response => {
                console.log(response.data)
                this.selected_manager = response.data.info1.emngr
                this.manager_toggler = true

                this.selected_cost_center = response.data.info1.ecurrdept
                this.selected_department = response.data.info1.ecostcenter
            }).catch(error => console.log(error.response.data))
        }
    },
    created(){
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

</style>