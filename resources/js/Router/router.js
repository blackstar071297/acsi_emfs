import Vue from 'vue'
import VueRouter from 'vue-router'
import AppStorage from '../components/Helpers/AppStorage'

//component imports

import DashboardComponent from '../components/DashboardComponent'
import loginComponent from '../components/LoginComponent'
import NewMovementFormComponent from '../components/NewMovementFormComponent'
import NewEmployeeComponent from '../components/NewEmployeeComponent'

Vue.use(VueRouter)

const guard = (to,from,next) => {
    let current_path = to.fullPath.split('/')
    document.title = process.env.MIX_APP_NAME + ' | ' + to.meta.title
    if(AppStorage.getToken()){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + AppStorage.getToken()
    }
    axios.post('/acsi_emfs/api/is-logged-in').then(response => {     
        response.data == false ? next({path : '/acsi_emfs/login'}) : next()
    }).catch(error => error.response.status == 401 ? next({path : '/acsi_emfs/login'}) : console.log(error.response.data))
}

let routes = [
    {path:'/acsi_emfs/',component:DashboardComponent,beforeEnter: guard},
    {path:'/acsi_emfs/new-movement-form',component:NewMovementFormComponent,beforeEnter: guard},
    {path:'/acsi_emfs/login',component:loginComponent},
    {path: '/acsi_emfs/new-employee',component: NewEmployeeComponent,beforeEnter: guard}
]
const router = new VueRouter({
    mode: 'history',
    hash: false,
    routes, // short for `routes: routes`
    
})


export default router