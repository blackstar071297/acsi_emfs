<template>
    <div>
        <form action="mailer" @submit.prevent="submit()">
            <input type="text" v-model="emailRecipient" placeholder="Receiptient">
            <input type="text" v-model="emailSubject" placeholder="Subject">
            <textarea v-model="emailBody" name="body" id="body" cols="30" rows="10"></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>
</template>

<script>
export default {
    data(){
        return {
            emailRecipient: null,
            emailSubject: null,
            emailBody: null,
            emailCc: 'christianaquino071297@gmail.com',
            emailBcc: 'christianaquino071297@gmail.com'
        }
    },
    methods:{
        submit(){
            const fd = new FormData()
            fd.append('emailRecipient',this.emailRecipient)
            fd.append('emailSubject',this.emailSubject)
            fd.append('emailBody',this.emailBody)
            fd.append('emailCc',this.emailCc)
            fd.append('emailBcc',this.emailBcc)
            axios.post('/api/mailer',fd).then(response => console.log(response.data)).catch(error => console.log(error.response.data))
        }
    }
}
</script>

<style>

</style>