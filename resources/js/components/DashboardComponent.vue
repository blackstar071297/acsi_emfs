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
                                        <input type="checkbox" class="custom-control-input" id="job_status">
                                        <label class="custom-control-label" for="job_status">JOB STATUS</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="job_level">
                                        <label class="custom-control-label" for="job_level">JOB LEVEL</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="role">
                                        <label class="custom-control-label" for="role">ROLE ASSIGNMENT</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="department">
                                        <label class="custom-control-label" for="department">DEPARTMENT</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="cost_center">
                                        <label class="custom-control-label" for="cost_center">COST CENTER</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="salary">
                                        <label class="custom-control-label" for="salary">SALARY</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="allowance">
                                        <label class="custom-control-label" for="allowance">MONTHLY ALLOWANCE</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="immediate_superior">
                                        <label class="custom-control-label" for="immediate_superior">IMMEDIATE SUPERIOR</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="department_manager">
                                        <label class="custom-control-label" for="department_manager">DEPARTMENT MANAGER</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="extion_of_contract">
                                        <label class="custom-control-label" for="extion_of_contract">EXTENSION OF CONTRACT</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="font-weight-bold border-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="others">
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
                                        <td v-if="selected_employee.length == 0">N/A</td>
                                        <td v-else>{{selected_employee.info1.supervisor.firstname}} {{selected_employee.info1.supervisor.middlename != null ? selected_employee.info1.supervisor.middlename : ''}}  {{selected_employee.info1.supervisor.lastname}}</td>
                                    </tr>
                                    <tr>
                                        <td v-if="selected_employee.length == 0">N/A</td>
                                        <td v-else>{{selected_employee.info1.manager.firstname}} {{selected_employee.info1.manager.middlename != null ? selected_employee.info1.manager.middlename : ''}}  {{selected_employee.info1.manager.lastname}}</td>
                                    </tr>
                                    <tr>
                                        <td><input type="date" name="eoc" id="eoc" placeholder="" class="border-0 text-center"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="other" id="other" placeholder="" class="border-0 text-center"></td>
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
                                        <td v-if="position_toggler == false">SAME</td>
                                        <td v-if="position_toggler == true">
                                            <select name="position_title" id="position_title" class="border-0 w-100" >
                                                <option v-for="(position,index) in positions" :key="index" i :value="position.eposition" >{{position.eposition}}</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-if="job_status_toggler == false">SAME</td>
                                        <td v-if="job_status_toggler == true">
                                            <select name="job_status" id="job_status" class="border-0 w-100" >
                                                <option value="Probationary">Probationary</option>
                                                <option value="Regular">Regular</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>SAME</td>
                                    </tr>
                                    <tr>
                                        <td>SAME</td>
                                    </tr>
                                    <tr>
                                        <td>SAME</td>
                                    </tr>
                                    <tr>
                                        <td>SAME</td>
                                    </tr>
                                    <tr>
                                        <td>SAME</td>
                                    </tr>
                                    <tr>
                                        <td>SAME</td>
                                    </tr>
                                    <tr>
                                        <td>SAME</td>
                                    </tr>
                                    <tr>
                                        <td>SAME</td>
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
                                <td style='font-weight: bold;' class="border-0">
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
                                        <h6 class="align-middle font-weight-bold"> {{selected_employee.firstname}} {{selected_employee.middlename != null ? selected_employee.middlename : ''}}  {{selected_employee.lastname}}</h6>
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
        }
    },
    methods:{
        getUsers(){
            axios.post('/acsi_emfs/api/employees').then(response => {
                console.log(response.data)
                this.employees = response.data
            }).catch(error => console.log(error.response.data))
        },
        search(value){
            this.getUser(value)
        },
        getUser(emp_no){
            axios.post('/acsi_emfs/api/employees/'+emp_no).then(response => {
                console.log(response.data)
                this.selected_employee = response.data
            }).catch(error => console.log(error.response.data))
        },
        getPositions(){
            axios.post('/acsi_emfs/api/positions').then(response => this.positions = response.data)
        }
    },
    created(){
        this.getUsers()
        this.getPositions()
    }
}
</script>

<style>

</style>