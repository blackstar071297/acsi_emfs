<template>
    <div>

        <div class="row align-items-center vh-100">
            <div class="col-12 col-md-3 col-lg-4 col-xl-2 mx-auto">
                <div class="card border-primary h-100">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title text-center font-weight-bold">EMFS</h3>
                    </div>
                    <div v-for="(alert,index) in alerts" :key="index" :class="`alert mx-2 my-2 fade show text-center alert-${alert.type}`" role="alert">
                        <strong class="text-center">{{ alert.message }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" @submit.prevent="login">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="user"><i class="fa-solid fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control " placeholder="Username" name="username" id="user" v-model="form.username">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="password"><i class="fa-solid fa-key"></i></span>
                                </div>
                                <input type="password" class="form-control" placeholder="Password"  name="password" ID="pass" v-model="form.password">
                            </div>
                            <button type="submit" class="btn btn-success w-100" name="submit">Login <i class="fa-solid fa-arrow-right-to-bracket"></i></button>
                        </form>
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
    components:{navbar},
    data(){
        return {
            form:{
                username: null,
                password: null
            },
            alerts:[]
        }
    },
    methods:{
        login(){
            this.alerts = []
            const fd = new FormData()
            axios.get('/acsi_emfs/sanctum/csrf-cookie').then(response => {
                // Login...
                fd.append('username',this.form.username == undefined ? '' : this.form.username)
                fd.append('password',this.form.password == undefined ? '' : this.form.password)
                axios.post('/acsi_emfs/api/login',fd).then(response => {
                    if(response.data.errors){
                        for(let error in response.data.errors){
                            this.alerts.push({message: response.data.errors[error][0],type: 'danger' })
                        } 
                    }else{
                        console.log(response)
                        let token = response.data.token
                        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
                        AppStorage.storeToken(token)
                        axios.post('/acsi_emfs/api/get-current-user').then(response =>{
                            if(response.data.position == 'fst'){
                                this.$router.push({path:'/acsi_emfs/fst/'})
                            }else{
                                this.$router.push({path:'/acsi_emfs/'})
                            }
                        })
                    }
                }).catch(error => console.log(error.response.data))
            });
            
        },
        getCookie(name) {
            function escape(s) { return s.replace(/([.*+?\^$(){}|\[\]\/\\])/g, '\\$1'); }
            var match = document.cookie.match(RegExp('(?:^|;\\s*)' + escape(name) + '=([^;]*)'));
            return match ? match[1] : null;
        },
        checkUser(){
            console.log(document.sessionStorage["empno"])
            console.log(1)
            if(document.sessionStorage["empno"] != null){
                let username = document.sessionStorage["empno"]
                let fd = new FormData()
                fd.append('emp_no',username)
                axios.post('/acsi_emfs/api/check-user',fd).then(response => {
                    console.log(response.data)
                    if(Object.keys(response.data).length > 0){
                        this.form.username = document.sessionStorage["empno"]
                        this.form.password = 'password'
                        this.login()
                    }else{
                        this.alerts.push({message: 'User not found!',type: 'danger' })
                    }
                })
            }
            
            
        }
    },
    created(){
        // this.checkUser()
    }
    
}
</script>

<style>

</style>