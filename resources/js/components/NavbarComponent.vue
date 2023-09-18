<template>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: #e3f2fd;">
        <a class="navbar-brand" href="/">
            <img src="/public/images/tsi_acsi_logo2.png" width="60" height="30" class="d-inline-block align-top" alt="logo" loading="lazy">
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
                    <a class="nav-link" href="/new-employee" v-if="current_user.useraccess == 'super_admin' && current_user.position == 'system_admin'">New employee</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Welcome {{ Object.keys(current_user).length > 0 ? current_user.firstname + ' ' + current_user.lastname : ''}}
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
            axios.post('/api/is-logged-in').then(response => {
                if(response.data == true){
                    this.getCurrentUser()
                }
            }).catch(error => console.log(error.response))
        },
        getCurrentUser(){
            if(AppStorage.getToken()){
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + AppStorage.getToken()
            }
            axios.post('/api/get-current-user').then(response => {
                this.current_user = response.data
            })
        },
        logout(){
            if(AppStorage.getToken()){
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + AppStorage.getToken()
            }
            axios.post('/api/logout').then(response => {
                // console.log(response.data)
                if(response.data == true){
                    this.$router.push({path:'/login'})
                    AppStorage.clear()
                }
            }).catch(error => console.log(error.response))
        },
        checkToken(){
            axios.post('/api/check-token').then(response => {
                console.log(response.data)
                
                if(response.data.token){
                    let token = response.data.token
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
                    AppStorage.storeToken(token)
                }
                
            })
        }
    },
    created(){
        this.checkUser()
        this.checkToken()
    }
}
</script>

<style>

</style>