import Vue from 'vue'
import VueRouter from 'vue-router'
// import AppStorage from '../components/Admin/Helpers/AppStorage'

//component imports

import DashboardComponent from '../components/DashboardComponent'
import loginComponent from '../components/LoginComponent'
Vue.use(VueRouter)

const guard = (to,from,next) => {
    let current_path = to.fullPath.split('/')
    document.title = process.env.MIX_APP_NAME + ' | ' + to.meta.title
    if(AppStorage.getToken()){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + AppStorage.getToken()
    }
    axios.post('/tsi_fsth/api/is-admin').then(response => {     
        response.data == false ? next({path : '/tsi_fsth/admin/login'}) : next()
    }).catch(error => error.response.status == 401 ? next({path : '/tsi_fsth/admin/login'}) : console.log(error.response.data))
}

let routes = [
    {path:'/acsi_emfs/',component:DashboardComponent},
    {path:'/acsi_emfs/login',component:loginComponent}
]
const router = new VueRouter({
    mode: 'history',
    hash: false,
    routes, // short for `routes: routes`
    
})


export default router