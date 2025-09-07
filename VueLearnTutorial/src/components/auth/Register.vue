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
                        Register
                    </h5>
                </div>
                <div class="card-body">
                    <form @submit.prevent="registerNewUser">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name*</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name*"
                                v-model="data.user.name" />
                        </div>
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
                    Already have an account? sign in from
                    <router-link to="/login">here</router-link>
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
        name: '',
        email: '',
        password: ''
    }
})

//register the new user
const registerNewUser = async () => {
    authStore.clearValidationErrors()
    authStore.isLoading = true
    try {
        const response = await axios.post(`${BASE_URL}/user/register`,
            data.user
        )
        authStore.isLoading = false
        toast.success(response.data.message, {
            timeout: 2000
        })
        router.push('/login')
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