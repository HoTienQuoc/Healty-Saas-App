<template>
    <div class="row my-5">
        <!-- spinner -->
        <Spinner :store="authStore" />
        <div class="col-md-6 mx-auto">
            <!-- display the validation errors -->
            <RenderFormValidationErrors />
            <div class="card rounded-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="text-center mt-2">
                        Login
                    </h5>
                </div>
                <div class="card-body">
                    <form @submit.prevent="loginUser">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email*</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email*"
                                v-model="data.user.email" />
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password*</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Password*" v-model="data.user.password" />
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-sm btn-dark btn-rounded-0">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-white text-center">
                    New user? sign up from
                    <router-link to="/register">here</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, onMounted } from 'vue'
import { useAuthStore } from '../../stores/useAuthStore'
import { useRouter } from 'vue-router'
import { useToast } from 'vue-toastification'
import { BASE_URL } from '../../helpers/config'
import axios from "axios"
import RenderFormValidationErrors from '../layouts/RenderFormValidationErrors.vue'
import Spinner from '../layouts/Spinner.vue'

//define the store
const authStore = useAuthStore()

//define the store
const router = useRouter()

//define the toast
const toast = useToast()

//define the data object
const data = reactive({
    user: {
        email: '',
        password: ''
    }
})

//register the new user
const loginUser = async () => {
    authStore.clearValidationErrors()
    authStore.isLoading = true
    try {
        const response = await axios.post(`${BASE_URL}/user/login`,
            data.user
        )
        authStore.isLoading = false
        authStore.setIsLoggedIn()
        authStore.setUser(response.data.user)
        authStore.setToken(response.data.access_token)
        toast.success(response.data.message, {
            timeout: 2000
        })
        router.push('/')
    } catch (error) {
        authStore.isLoading = false
        if (error?.response?.status === 422) {
            authStore.setFormValidationErrors(error.response.data.errors)
        }
        console.log(error)
    }
}

//once the component is mounted we need to clear the validation errors
onMounted(() => authStore.clearValidationErrors())
</script>

<style></style>