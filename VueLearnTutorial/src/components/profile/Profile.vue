<template>
    <div class="card border border-light border-4 rounded shadow-sm my-3">
        <div class="card-body">
            <div class="container">
                <Navbar />
                <div class="row my-5">
                    <div class="col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item border border-2 border-dark text-center mb-2">
                                <i class="bi bi-person"></i> {{ authStore?.user?.name }}
                            </li>
                            <li class="list-group-item border border-2 border-dark text-center mb-2">
                                <i class="bi bi-envelope"></i> {{ authStore?.user?.email }}
                            </li>
                            <li class="list-group-item border border-2 border-dark text-center mb-2">
                                <i class="bi bi-heart-fill"></i> {{ authStore?.user?.number_of_hearts }}
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-8 d-flex justify-content-between align-items-center"
                        v-if="authStore?.user?.subscriptions?.length">
                        <h5>
                            You are subscribed to
                            {{
                                authStore.user.subscriptions.length > 1 ? "plans" : "plan"
                            }}
                        </h5>
                        <div class="d-flex flex-column">
                            <div v-for="subscription in authStore.user.subscriptions" :key="subscription.id">
                                <span class="badge bg-dark p-2 mx-2 mb-2">
                                    {{ subscription.plan.name }}
                                </span>
                                <span class="fw-bold me-2">
                                    {{ subscription.current_period_end }}
                                </span>
                                <button class="btn btn-danger rounded me-1 mb-1"
                                    @click="unsubscribe(subscription.stripe_subscription_id)" :disabled="data.loading">
                                    <i class="bi bi-x-circle"></i> cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios"
import { reactive } from "vue"
import { useRouter } from "vue-router"
import { useToast } from "vue-toastification"
import { BASE_URL, headersConfig } from "../../helpers/config"
import { useAuthStore } from "../../stores/useAuthStore"
import Navbar from "../layouts/Navbar.vue"

//define the auth store
const authStore = useAuthStore()

//define the router
const router = useRouter()

//define the toast
const toast = useToast()

//define the data object
const data = reactive({
    loading: false
})

//cancel subscription function
const unsubscribe = async (stripe_subscription_id) => {
    data.loading = true
    try {
        const response = await axios.post(`${BASE_URL}/cancel`,
            {
                stripe_subscription_id
            },
            headersConfig(authStore.access_token)
        )

        if (response.data.error) {
            data.loading = false
            toast.error(response.data.error, {
                timeout: 2000
            });
        } else {
            authStore.setUser(response.data.user)
            data.loading = false
            toast.success(response.data.message, {
                timeout: 2000
            });
        }
    } catch (error) {
        data.loading = false
        console.log(error)
    }

}
</script>

<style scoped></style>