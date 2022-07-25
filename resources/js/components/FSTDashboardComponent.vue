<template>
    <div>
        <navbar></navbar>
        <div class="container mt-4">
            
            <h1>FST Dashboard</h1>
            
            <table class="table table-bordered table-striped">
                <thead>
                    <th scope="col">Request no.</th>
                    <th>Employee name</th>
                    <th>Requestor</th>
                    <th>Reason of transfer</th>
                    <th>Effectivity date</th>
                    <th>Status</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <tr v-for="(form,index) in forms" :key="index">
                        <td><a :href="'/acsi_emfs/approvals/'+form.request_no">{{form.request_no}}</a></td>
                        <td>{{form.employee.firstname}} {{form.employee.lastname}}</td>
                        <td>{{form.requestor.firstname}} {{form.requestor.lastname}}</td>
                        <td>{{form.reason_for_movement == null ? 'N/A' : form.reason_for_movement}}</td>
                        <td>{{form.effectivity_date}}</td>
                        <td>{{form.records[0].status.status}}</td>
                        <td>
                            <a :href="'/acsi_emfs/approvals/'+form.request_no" class="btn btn-primary mb-1"><i class="fa-solid fa-eye"></i></a>
                            <a :href="'/acsi_emfs/approvals/'+form.request_no" class="btn btn-success mb-1" v-if="checkUser(form)"><i class="fa-solid fa-check"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            
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
            current_user:[]
        }
    },
    methods:{
        getForms(){
            axios.post('/acsi_emfs/api/fst/employee-movement-form').then(response => {
                console.log(response.data)
                this.forms = response.data
            }).catch(error => console.log(error.response.data))
        },
        getCurrentUser(){
            axios.post('/acsi_emfs/api/get-current-user').then(response => {this.current_user = response.data})
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