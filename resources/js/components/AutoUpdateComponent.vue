<template>
    <div>
        <h1>Auto update.</h1>
        <h5 :class="'font-weight-bold text-' + update_color">Status: {{ update_status }}</h5>
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
            axios.post('/api/test').then(response => {
                response.data == 'success' ? this.update_status = 'Success' : 'Failed'
                response.data == 'success' ? this.update_color = 'success' : 'danger'
            })
        },
        reminder(){
            axios.post('/api/email-reminder').then(response => {
                response.data == 'success' ? this.reminder_status = 'Success' : 'Failed'
                response.data == 'success' ? this.reminder_color = 'success' : 'danger'
            }).catch(error => console.log(error.response.data))
        }
    },
    created(){
        this.update()
    }
}
</script>

<style>

</style>