<template>

</template>

<script>
import AppStorage from '../components/Helpers/AppStorage'
export default {
    methods:{
        saveToken(){
            let token = this.$route.params.token
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
            AppStorage.storeToken(token)
            this.$router.push({path:'/'})
        },
        login(){
            this.alerts = []
            const fd = new FormData()
            axios.get('/sanctum/csrf-cookie').then(response => {
                // Login...
                fd.append('username',this.$route.params.empno)
                fd.append('password','password')
                axios.post('/api/login',fd).then(response => {
                    if(response.data.errors){
                        this.$router.push({path:'/login/'})
                    }else{
                        console.log(response)
                        let token = response.data.token
                        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
                        AppStorage.storeToken(token)
                        axios.post('/api/get-current-user').then(response =>{
                            if(response.data.position == 'fst'){
                                this.$router.push({path:'/fst/'})
                            }else{
                                this.$router.push({path:'/'})
                            }
                        })
                    }
                }).catch(error => console.log(error.response.data))
            });
        }
    },
    created(){
        this.login()
    }

}
</script>

<style>

</style>