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
                                        <input type="checkbox" class="custom-control-input" id="position_title" v-model="form.move_position" disabled>
                                        <label class="custom-control-label" for="position_title">POSITION TITLE</label>
                                    </div>
                                </td>
                            </tr>
                            <tr >
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="job_status" v-model="form.move_job_status" disabled>
                                        <label class="custom-control-label" for="job_status">JOB STATUS</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="job_level" v-model="form.move_job_level" disabled>
                                        <label class="custom-control-label" for="job_level">JOB LEVEL</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="role" v-model="form.move_role" disabled>
                                        <label class="custom-control-label" for="role">ROLE ASSIGNMENT</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="department" v-model="form.move_department" disabled>
                                        <label class="custom-control-label" for="department">DEPARTMENT</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="cost_center" v-model="form.move_cost_center" disabled>
                                        <label class="custom-control-label" for="cost_center">COST CENTER</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="salary" v-model="form.move_salary" disabled>
                                        <label class="custom-control-label" for="salary">SALARY</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="allowance" v-model="form.move_allowance" disabled>
                                        <label class="custom-control-label" for="allowance">MONTHLY ALLOWANCE</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="immediate_superior" v-model="form.move_immediate_superior" disabled>
                                        <label class="custom-control-label" for="immediate_superior">IMMEDIATE SUPERIOR</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="department_manager" v-model="form.move_manager" disabled>
                                        <label class="custom-control-label" for="department_manager">DEPARTMENT MANAGER</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="extion_of_contract" v-model="form.move_contract" disabled>
                                        <label class="custom-control-label" for="extion_of_contract">EXTENSION OF CONTRACT</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold ">
                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="others" v-model="form.move_others" disabled>
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
                                        <td>{{ form.from_position }}</td>
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
                                        <td>{{ selected_supervisor.firstname}} {{ selected_supervisor.lastname}}</td>
                                        
                                    </tr>
                                    <tr>
            
                                        <td >{{selected_employee.info1.manager.firstname}}  {{selected_employee.info1.manager.lastname}}</td>
                                    </tr>
                                    <tr>
                                        
                                        <td ><input type="date" name="eoc" id="eoc"  class="border-0 text-center" ></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="other" id="other"  class="border-0 text-center h-100"></td>
                                    </tr>
                                    <tr class=" d-print-none">
                                        <td><input type="text" name="reason_for_transfer" id="reason_for_transfer" class="h-100 border-0" v-model="reason"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="date" name="effective_date" id="effective_date" class="text-center border-0 h-100" :min="new Date().toISOString().slice(0, -14)" v-model="effectivity_date"></td>
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
                                        {{form.to_job_status == null ? 'SAME' : form.to_job_status}}
                                    </tr>
                                    <tr>
                                        <td v-if="job_level_toggler == false">SAME</td>
                                        <td v-if="job_level_toggler == true">
                                            <select name="job_level" id="job_level" class="border-0 w-100 text-center" v-model="selected_level">
                                                <option v-for="(job_level,index) in job_level" :key="index" :value="job_level.job_name">{{job_level.job_name}}</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="role_toggler == false">SAME</td>
                                        <td v-if="role_toggler == true">
                                            <select name="role" id="role" class="border-0 w-100 text-center" v-model="selected_role" :disabled="current_user.position == 'hr_officer' || current_user.position == 'supervisor' || current_user.position == 'manager' ? false : true">
                                                <option value="">N/A</option>
                                                <option v-for="(role,index) in roles" :key="index" :value="role.role_name">{{role.role_name}}</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <label></label>
                                    </tr>
                                    <tr>
                                        <td v-if="cost_toggler == false">SAME</td>
                                        <td v-if="cost_toggler == true">
                                            <select name="cost_center" id="cost_center" class="border-0 w-100 text-center" v-model="selected_cost_center">
                                                <option v-for="(cost_center,index) in cost_centers" :key="index" :value="cost_center.ccname" :selected="cost_center.ccname == selected_cost_center ? true : false">{{cost_center.ccname}}</option>
                                            </select>
                                            <!-- {{selected_cost_center}} -->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="salary_toggler == false">SAME</td>
                                        <input v-else type="text" name="to_salary" id="to_salary" placeholder="" class="border-0 text-center h-100" :disabled="current_user.position == 'hr_officer' ? false : true">
                                    </tr>
                                    <tr>
                                        <td v-if="allowance_toggler == false">SAME</td>
                                        <input v-else type="text" name="to_allowance" id="to_allowance" :v-model="to_allowance" placeholder="" class="border-0 text-center h-100" :disabled="current_user.position == 'supervisor' || current_user.position == 'manager' ? false : true">
                                    </tr>
                                    <tr>
                                        <td v-if="supervisor_toggler == false">SAME</td>
                                        <td v-if="supervisor_toggler == true">
                                            <select name="supervisor" id="supervisor" class="border-0 w-100 text-center" v-model="selected_supervisor.empno" @change="supervisorUpdate($event.target.value)" :disabled="current_user.position == 'supervisor' || current_user.position == 'manager' ? false : true">
                                                <option v-for="(supervisor,index) in supervisors" :key="index" :value="supervisor.empno" >{{supervisor.user.firstname}} {{supervisor.user.lastname}}</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="manager_toggler == false">SAME</td>
                                        <td v-if="manager_toggler == true">
                                            <select name="supervisor" id="supervisor" class="border-0 w-100 text-center" v-model="selected_manager" :disabled="current_user.position == 'hr_officer' ? false : true">
                                                <option v-for="(manager,index) in managers" :key="index" :value="manager.empno" :selected="selected_manager == manager.empno ? true : false">{{manager.user.firstname}} {{manager.user.lastname}}</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>SAME</td>
                                    </tr>
                                    <tr>
                                        <td>SAME</td>
                                    </tr>
                                    <tr class=" d-print-none">
                                        <td class="h-100 text-white">SAME</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <button class="btn btn-primary w-100" @click.prevent="submit()" :disabled="Object.keys(selected_employee).length > 0 ? false : true">Submit</button>
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
                                        <h6 class="align-middle font-weight-bold">Sunshine Cunanan</h6>
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
                                <td style='font-weight: bold;' class="border-0 w-50">
                                    <br>
                                    <br>
                                    <div class="text-center mt-5">
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
import AppStorage from '../components/Helpers/AppStorage'
export default {
    components:{navbar},
    data(){
        return{
            form:[],
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
            current_supervisor:[],
            current_manager:[],
            selected_supervisor: [],
            selected_manager: [],
            effectivity_date: new Date().toISOString().slice(0, -14),
            
            reason:[],
            from_allowance: 0,
            to_allowance:0
        }
    },
    methods:{
        getForm(){
            axios.get('/acsi_emfs/api/employee-movement-form/'+this.$route.params.request_no).then(response => {
                this.form = response.data
                this.selected_employee = this.getUser(response.data.employee.empno)
            })
        },
        getUser(emp_no){
            axios.post('/acsi_emfs/api/employees/'+emp_no).then(response => {
                // console.log(response.data)
                return response.data
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
        getCurrentUser(){
            if(AppStorage.getToken()){
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + AppStorage.getToken()
            }
            axios.post('/acsi_emfs/api/get-current-user').then(response => {
                console.log(response.data)
                this.current_user = response.data
            })
        },
    },
    created(){
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