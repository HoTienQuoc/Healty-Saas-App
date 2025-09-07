<template>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <router-link to="/" class="navbar-brand" href="#">
                <img src="https://cdn.pixabay.com/photo/2021/01/18/16/02/avocado-5928508_1280.png" alt="logo" width="60"
                    height="60" class="rounded">
            </router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link to="/" class="nav-link active" aria-current="page">
                            <i class="bi bi-house-door-fill"></i> Home
                        </router-link>
                    </li>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link to="/profile" class="nav-link" aria-current="page">
                                <i class="bi bi-person-check-fill"></i> {{ authStore?.user?.name }}
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="#" @click="logoutUser" class="nav-link" aria-current="page">
                                <i class="bi bi-box-arrow-left"></i> Logout
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/history" class="nav-link" aria-current="page">
                                <i class="bi bi-clock-history"></i> History
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="#" class="nav-link" aria-current="page">
                                <span>
                                    <i class="bi bi-heart-fill text-danger h3"></i>
                                </span>
                                <span class="fw-bold">
                                    <i>x{{ authStore?.user?.number_of_hearts }}</i>
                                </span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/plans" v-if="authStore?.user?.number_of_hearts === 0"
                                class="btn btn-warning" aria-current="page">
                                Upgrade
                            </router-link>
                        </li>
                    </ul>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { onMounted } from "vue"
import { headersConfig, BASE_URL } from "../../helpers/config"
import { useAuthStore } from "../../stores/useAuthStore"
import axios from "axios"
import { useProductStore } from "../../stores/useProductStore"
import { useRouter } from 'vue-router'
import { useToast } from 'vue-toastification'

//define the store
const authStore = useAuthStore()
const productStore = useProductStore()

//define the store
const router = useRouter()

//define the toast
const toast = useToast()

//logout function 
const logoutUser = async () => {
    try {
        const response = await axios.post(`${BASE_URL}/user/logout`,
            null, headersConfig(authStore.access_token)
        )
        authStore.clearAuthData()
        productStore.product = null
        toast.success(response.data.message, {
            timeout: 2000
        })
        router.push('/login')
    } catch (error) {
        console.log(error)
    }
}

//fetch the currently logged in user function 
const fetchCurrentUser = async () => {
    try {
        const response = await axios.get(`${BASE_URL}/user`,
            headersConfig(authStore.access_token)
        )
        authStore.setIsLoggedIn()
        authStore.setUser(response.data.user)
        authStore.setToken(response.data.access_token)
    } catch (error) {
        if (error?.response?.status === 401) {
            authStore.clearAuthData()
            router.push('/login')
        }
        console.log(error)
    }
}

//once the component is mounted we get the currently logged in user
onMounted(() => authStore.isLoggedIn && fetchCurrentUser())
</script>

<style scoped>
.navbar a {
    font-size: 1.1rem;
    font-weight: 700;
    margin-right: 0.7rem;
}
</style>