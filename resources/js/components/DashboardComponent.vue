<template>
    <div>
        <navbar></navbar>
        <div class="container-fluid mt-4">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                </ol>
            </nav>
            <a href="/new-movement-form" class="btn btn-success mb-2">New movement form <i class="fa-solid fa-plus"></i></a>
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="pills-pending-tab" data-toggle="pill" href="#pills-pending" role="tab" aria-controls="pills-home" aria-selected="true">Pending</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Completed</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Cancelled</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-pending" role="tabpanel" aria-labelledby="pills-pending-tab">
                    <table class="table table-bordered table-striped table-sm" v-if="Object.keys(pending).length > 0">
                        <thead>
                            <th scope="col">#</th>
                            <th >Request no.</th>
                            <th>Employee name</th>
                            <th>Requestor</th>
                            <th>Date created</th>
                            <th>Reason of transfer</th>
                            <th>Effectivity date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <tr v-for="(form,index) in pending" :key="index">
                                <td>{{index+1}}</td>
                                <td><a :href="'/approvals/'+form.request_no">{{form.request_no}}</a></td>
                                <td>{{form.employee.firstname}} {{form.employee.lastname}}</td>
                                <td>{{form.requestor.firstname}} {{form.requestor.lastname}}</td>
                                <td>{{form.created_at}}</td>
                                <td>{{form.reason_for_movement == null ? 'N/A' : form.reason_for_movement}}</td>
                                <td>{{form.effectivity_date}}</td>
                                <td class="text-capitalize" >{{form.records[0].status.status}}</td>
                                <td>
                                    <a :href="'/approvals/'+form.request_no" class="btn btn-primary mb-1"><i class="fa-solid fa-eye"></i></a>
                                    <a :href="'/approvals/'+form.request_no" class="btn btn-success mb-1" v-if="checkUser(form)"><i class="fa-solid fa-check"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-else>
                        <h5 class="text-center">NOTHING TO DISPLAY</h5>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <table class="table table-bordered table-striped table-sm" v-if="Object.keys(completed).length > 0">
                        <thead>
                            <th scope="col">#</th>
                            <th >Request no.</th>
                            <th>Employee name</th>
                            <th>Requestor</th>
                            <th>Date created</th>
                            <th>Reason of transfer</th>
                            <th>Effectivity date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <tr v-for="(form,index) in completed" :key="index">
                                <td>{{index+1}}</td>
                                <td><a :href="'/approvals/'+form.request_no">{{form.request_no}}</a></td>
                                <td>{{form.employee.firstname}} {{form.employee.lastname}}</td>
                                <td>{{form.requestor.firstname}} {{form.requestor.lastname}}</td>
                                <td>{{form.created_at}}</td>
                                <td>{{form.reason_for_movement == null ? 'N/A' : form.reason_for_movement}}</td>
                                <td>{{form.effectivity_date}}</td>
                                <td class="text-capitalize" >{{form.records[0].status.status}}</td>
                                <td>
                                    <a :href="'/approvals/'+form.request_no" class="btn btn-primary mb-1"><i class="fa-solid fa-eye"></i></a>
                                    <a :href="'/approvals/'+form.request_no" class="btn btn-success mb-1" v-if="checkUser(form)"><i class="fa-solid fa-check"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-else>
                        <h5 class="text-center">NOTHING TO DISPLAY</h5>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <table class="table table-bordered table-striped table-sm" v-if="Object.keys(pending).length > 0">
                        <thead>
                            <th scope="col">#</th>
                            <th>Request no.</th>
                            <th>Employee name</th>
                            <th>Requestor</th>
                            <th>Date created</th>
                            <th>Reason of transfer</th>
                            <th>Effectivity date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <tr v-for="(form,index) in cancelled" :key="index">
                                <td>{{index+1}}</td>
                                <td><a :href="'/approvals/'+form.request_no">{{form.request_no}}</a></td>
                                <td>{{form.employee.firstname}} {{form.employee.lastname}}</td>
                                <td>{{form.requestor.firstname}} {{form.requestor.lastname}}</td>
                                <td>{{form.created_at}}</td>
                                <td>{{form.reason_for_movement == null ? 'N/A' : form.reason_for_movement}}</td>
                                <td>{{form.effectivity_date}}</td>
                                <td class="text-capitalize" >{{form.records[0].status.status}}</td>
                                <td>
                                    <a :href="'/approvals/'+form.request_no" class="btn btn-primary mb-1"><i class="fa-solid fa-eye"></i></a>
                                    <a :href="'/approvals/'+form.request_no" class="btn btn-success mb-1" v-if="checkUser(form)"><i class="fa-solid fa-check"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-else>
                        <h5 class="text-center">NOTHING TO DISPLAY</h5>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
</template>

<script>
import navbar from '../components/NavbarComponent.vue'
import AppStorage from '../components/Helpers/AppStorage'
export default {
    components: {navbar},
    data(){
        return{
            forms:[],
            current_user:[],
            completed: [],
            pending:[],
            cancelled:[]
        }
    },
    methods:{
        getForms(){
            axios.get('/api/employee-movement-form').then(response => {
                console.log(response.data)
                this.forms = response.data
                this.forms.forEach((form) =>{
                    if(form.records[0].status_id == 10){
                        this.cancelled.push(form)
                    }else if(form.records[0].status_id == 9 && form.is_closed == 1){
                        this.completed.push(form)
                    }else{
                        this.pending.push(form)
                    }
                })
            }).catch(error => console.log(error.response.data))
        },
        getCurrentUser(){
            axios.post('/api/get-current-user').then(response => {
                this.current_user = response.data
                if(response.data.position == 'fst'){
                    this.$router.push({path:'/fst/'})
                }
            })
        },
        checkUser(form){
            if(form.records[0].status_id == 1 && form.from_immediate_superior == this.current_user.empno){
                return true
            }else if(form.records[0].status_id == 2 && form.from_manager == this.current_user.empno){
                return true
            }else if(form.records[0].status_id == 4 && form.to_manager == this.current_user.empno){
                return true
            }else if(form.records[0].status_id == 5 && this.current_user.empno == 'ACSI-200634'){
                return true
            }else if(form.records[0].status_id == 6 && form.hr_account_officer == this.current_user.empno){
                return true
            }else if(form.records[0].status_id == 7 && form.emp_no == this.current_user.empno){
                return true
            }else{
                return false
            }
            
        },
        test(){
            axios.post('/api/test').then(response => console.log(response.data)).catch(error => console.log(error.response.data))
        }
        
    },
    created(){
        if(AppStorage.getToken()){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + AppStorage.getToken()
        }
        this.getForms()
        this.getCurrentUser()
    }
}
</script>

<style>

</style>