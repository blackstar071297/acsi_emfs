<template>
    <div>
        <h1>Email reminder.</h1>
        <h5 :class="'font-weight-bold text-' + reminder_color">Status: {{ reminder_status }}</h5>
    </div>
</template>

<script>
export default {
    data(){
        return{
            update_status: 'Loading',
            update_color: 'primary',
            reminder_status: 'Loading',
            reminder_color: 'primary'
        }
    },
    methods:{
        update(){
            axios.post('/acsi_emfs/api/test').then(response => {
                response.data == 'success' ? this.update_status = 'Success' : 'Failed'
                response.data == 'success' ? this.update_color = 'success' : 'danger'
            })
        },
        reminder(){
            axios.post('/acsi_emfs/api/email-reminder').then(response => {
                response.data == 'success' ? this.reminder_status = 'Success' : 'Failed'
                response.data == 'success' ? this.reminder_color = 'success' : 'danger'
            }).catch(error => console.log(error.response.data))
        }
    },
    created(){
        this.reminder()
    }
}
</script>

<style>

</style>