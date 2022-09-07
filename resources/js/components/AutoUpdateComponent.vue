<template>
    <div>
        <h1>Auto update.</h1>
        <h5 :class="'font-weight-bold text-' + color">Status: {{ status }}</h5>

    </div>
</template>

<script>
export default {
    data(){
        return{
            status: 'Loading',
            color: 'primary'
        }
    },
    methods:{
        update(){
            axios.post('/acsi_emfs/api/test').then(response => {
                response.data == 'success' ? this.status = 'Success' : 'Failed'
                response.data == 'success' ? this.color = 'success' : 'danger'
            })
        }
    },
    created(){
        this.update()
    }
}
</script>

<style>

</style>