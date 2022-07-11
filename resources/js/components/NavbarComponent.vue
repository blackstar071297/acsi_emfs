<template>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: #e3f2fd;">
        <a class="navbar-brand" href="/acsi_emfs">
            <img src="/acsi_emfs/public/images/tsi_acsi_logo2.png" width="60" height="30" class="d-inline-block align-top" alt="" loading="lazy">
            <span class="d-xs-none">Employee Movement Form</span> 
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/acsi_emfs/new-employee" v-if="current_user.useraccess == 'super_admin' && current_user.position == 'system_admin'">New employee</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Welcome {{ Object.keys(current_user).length > 0 ? current_user.empno : ''}}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="logout.php" @click.prevent="logout()">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
import AppStorage from './Helpers/AppStorage'

export default {
    components:{},
    data(){
        return {
            current_user: []
        }
    },
    methods:{
        checkUser(){
            if(AppStorage.getToken()){
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + AppStorage.getToken()
            }
            axios.post('/acsi_emfs/api/is-logged-in').then(response => {
                if(response.data == true){
                    this.getCurrentUser()
                }
            }).catch(error => console.log(error.response))
        },
        getCurrentUser(){
            if(AppStorage.getToken()){
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + AppStorage.getToken()
            }
            axios.post('/acsi_emfs/api/get-current-user').then(response => {this.current_user = response.data})
        },
        logout(){
            if(AppStorage.getToken()){
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + AppStorage.getToken()
            }
            axios.post('/acsi_emfs/api/logout').then(response => {
                if(response.data == true){
                    this.$router.push({path:'/acsi_emfs/login'})
                    AppStorage.clear()
                }
            }).catch(error => console.log(error.response))
        }
    },
    created(){
        this.checkUser()
    }
}
</script>

<style>

</style>