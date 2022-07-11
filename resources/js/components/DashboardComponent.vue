<template>
    <div>
        <navbar></navbar>
        <div class="container mt-4">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                </ol>
            </nav>
            <a href="/acsi_emfs/new-movement-form" class="btn btn-success mb-2">New movement form <i class="fa-solid fa-plus"></i></a>
            
            <table class="table table-bordered table-stripe">
                <thead>
                    <th scope="col">Request no.</th>
                    <th>Employee name</th>
                    <th>Requestor</th>
                    <th>Reason of transfer</th>
                    <th>Status</th>
                </thead>
            </table>
        </div>
    </div>
</template>

<script>
import navbar from '../components/NavbarComponent.vue'
export default {
    components: {navbar}
}
</script>

<style>

</style>