import { createRouter, createWebHashHistory } from 'vue-router'
import { useAuthStore } from '../stores/useAuthStore'
const Home = () => import('../components/Home.vue')
const Register = () => import('../components/auth/Register.vue')
const Login = () => import('../components/auth/Login.vue')
const Plans = () => import('../components/plans/Plans.vue')
const Profile = () => import('../components/profile/Profile.vue')
const History = () => import('../components/history/History.vue')

function checkIfUserIsLoggedIn()
{
    const authStore = useAuthStore()
    if(!authStore.isLoggedIn) return '/login'
}

function checkIfUserIsNotLoggedIn()
{
    const authStore = useAuthStore()
    if(authStore.isLoggedIn) return '/'
}

const router = createRouter({
    history: createWebHashHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            beforeEnter: [checkIfUserIsLoggedIn]
        },
        {
            path: '/plans',
            name: 'plans',
            component: Plans,
            beforeEnter: [checkIfUserIsLoggedIn]
        },
        {
            path: '/profile',
            name: 'profile',
            component: Profile,
            beforeEnter: [checkIfUserIsLoggedIn]
        },
        {
            path: '/history',
            name: 'history',
            component: History,
            beforeEnter: [checkIfUserIsLoggedIn]
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
            beforeEnter: [checkIfUserIsNotLoggedIn]
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            beforeEnter: [checkIfUserIsNotLoggedIn]
        }
    ]
})

export default router