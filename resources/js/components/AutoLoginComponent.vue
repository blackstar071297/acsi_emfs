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
            this.$router.push({path:'/acsi_emfs/'})
        },
        login(){
            this.alerts = []
            const fd = new FormData()
            axios.get('/acsi_emfs/sanctum/csrf-cookie').then(response => {
                // Login...
                fd.append('username',this.$route.params.empno)
                fd.append('password','password')
                axios.post('/acsi_emfs/api/login',fd).then(response => {
                    if(response.data.errors){
                        this.$router.push({path:'/acsi_emfs/login/'})
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
        }
    },
    created(){
        this.login()
    }

}
</script>

<style>

</style>