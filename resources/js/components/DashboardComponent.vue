<template>
    <div>
        <navbar></navbar>
        <div class="container mt-4">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                </ol>
            </nav>
            <a href="/acsi_emfs/new-movement-form" class="btn btn-success mb-2">New movement form <i class="fa-solid fa-plus"></i></a>
            
            <table class="table table-bordered table-stripe">
                <thead>
                    <th scope="col">Request no.</th>
                    <th>Employee name</th>
                    <th>Requestor</th>
                    <th>Reason of transfer</th>
                    <th>Effectivity date</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    <tr v-for="(form,index) in forms" :key="index">
                        <td><a href="#">{{form.request_no}}</a></td>
                        <!-- <td><a :href="'/acsi_emfs/approvals/'+form.request_no">{{form.request_no}}</a></td> -->
                        <td>{{form.employee.firstname}} {{form.employee.lastname}}</td>
                        <td>{{form.requestor.firstname}} {{form.requestor.lastname}}</td>
                        <td>{{form.reason_for_movement == null ? 'N/A' : form.reason_for_movement}}</td>
                        <td>{{form.effectivity_date}}</td>
                        <td>{{form.records[0].status.status}}</td>
                    </tr>
                </tbody>
            </table>
            
        </div>
    </div>
</template>

<script>
import navbar from '../components/NavbarComponent.vue'
export default {
    components: {navbar},
    data(){
        return{
            forms:[]
        }
    },
    methods:{
        getForms(){
            axios.get('/acsi_emfs/api/employee-movement-form').then(response => {
                console.log(response.data)
                this.forms = response.data
            }).catch(error => console.log(error.response.data))
        },
        
    },
    created(){
        this.getForms()
    }
}
</script>

<style>

</style>