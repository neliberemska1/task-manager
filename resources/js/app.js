require('./bootstrap');

import {createApp} from 'vue'
import * as VueRouter from 'vue-router'

import HomeComponent from './components/HomeComponent.vue'
import TaskComponent from './components/TaskComponent.vue'
import MyTasksComponent from './components/MyTasksComponent.vue'


const routes = [
    {path: '/', component: HomeComponent},
    {path: '/tasks', component: TaskComponent},
    {path: '/mytasks', component: MyTasksComponent},
]

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory('/task-manager/public/'),
    routes,
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
})

const app = createApp({})

window.url = '/task-manager/public/';

app.use(router)

app.mount('#app')
