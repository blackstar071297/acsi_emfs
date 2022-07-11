<template>
    <div>
        <navbar></navbar>
        <div class="container mt-4">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/acsi_emfs">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">New employee</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-body">
                    <div v-for="(alert,index) in alerts" :key="index" :class="`alert mx-2 my-2 fade show text-center alert-${alert.type}`" role="alert">
                        <strong class="text-center">{{ alert.message }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="register.php" @submit.prevent="register()" >
                        <div class="form-group">
                            <label for="emp_no">Employee no</label>
                            <input type="text" name="emp_no" id="emp_no" class="form-control" v-model="form.emp_no">
                        </div>
                        <div class="form-group">
                            <label for="first_name">First name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" v-model="form.first_name">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" v-model="form.last_name">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" v-model="form.username">
                        </div>
                        <div class="form-group">
                            <label for="password" >Password</label>
                            <input type="password" name="password" id="password" class="form-control" v-model="form.password">
                        </div>
                        <div class="form-group">
                            <label for="access_level">Access level</label>
                            <select name="access_level" id="access_level" class="form-control" v-model="form.access_level">
                                <option value="super_admin">Super admin</option>
                                <option value="viewer">Viewer</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="position">Position</label>
                            <select name="position" id="position" class="form-control" v-model="form.position">
                                <option value="supervisor">Supervisor</option>
                                <option value="manager">Manager</option>
                                <option value="system_admin">System administrator</option>
                                <option value="hr_officer">HR Officer</option>
                            </select>
                        </div>
                        <button class="btn btn-primary w-100" type="submit">Add new employee</button>
                    </form>
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
        return {
            form:{
                emp_no:'',
                first_name: '',
                last_name: '',
                username:'',
                password:'',
                access_level: 'super_admin',
                position: 'system_admin',
                
            },
            alerts:[]

        }
    },
    methods:{
        register(){
            this.alerts = []
            let fd = new FormData()
            fd.append('emp_no',this.form.emp_no)
            fd.append('first_name',this.form.first_name)
            fd.append('last_name',this.form.last_name)
            fd.append('username',this.form.username)
            fd.append('password',this.form.password)
            fd.append('access_level',this.form.access_level)
            fd.append('position',this.form.position)
            
            axios.post('/acsi_emfs/api/register',fd).then(response => {
                if(response.data.errors){
                    for(let error in response.data.errors){
                        this.alerts.push({message: response.data.errors[error][0],type: 'danger' })
                    } 
                }else{
                    this.alerts.push({message: 'New employee added',type: 'success' })
                }
            }).catch(error => console.log(error.response))
        }
    }
    
}
</script>

<style>

</style>