<template>
    <div class="card border border-light border-4 rounded shadow-sm my-3">
        <Spinner :store="data.store" />
        <div class="card-body">
            <div class="container">
                <Navbar />
                <div class="row">
                    <div class="col-md-12">
                        <div class="row my-5">
                            <div class="col-md-4" v-for="plan in data.plans" :key="plan.id">
                                <div class="card border border-dark border-2 bg-white shadow">
                                    <div
                                        class="card-header border-bottom border-dark border-2 fw-bold text-center bg-white">
                                        {{ plan.name }}
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <span class="fw-bold">$</span>
                                                <h1>{{ plan.price }}</h1>
                                                <span class="text-danger fw-bold mx-1">
                                                    /
                                                </span>
                                                Month
                                            </div>
                                            <div>
                                                <span class="fw-bold">
                                                    {{ plan.number_of_hearts }} <i
                                                        class="bi bi-heart-fill text-danger"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer border-top border-dark border-2 text-center bg-white">
                                        <button class="btn btn-danger rounded-0" @click="authStore.setChosenPlan(plan)">
                                            <i class="bi bi-check2-circle me-1"></i> Choose plan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3" v-if="authStore?.chosenPlan">
                    <div class="col-md-6 mx-auto">
                        <div class="card bg-light">
                            <div class="card-body">
                                <!-- stripe subscription form -->
                                <StripeSubscriptionForm />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, onUnmounted, reactive } from "vue"
import axios from "axios"
import { useRouter } from "vue-router"
import { BASE_URL, headersConfig } from "../../helpers/config"
import { useAuthStore } from "../../stores/useAuthStore"
import Spinner from "../layouts/Spinner.vue"
import Navbar from "../layouts/Navbar.vue"
import StripeSubscriptionForm from "../payment/StripeSubscriptionForm.vue"


//define the store
const authStore = useAuthStore()

//define the store
const router = useRouter()

//define the data object
const data = reactive({
    plans: [],
    store: {
        isLoading: false
    }
})

//fetch all the plans 
const fetchPlans = async () => {
    data.store.isLoading = true
    try {
        const response = await axios.get(`${BASE_URL}/plans`,
            headersConfig(authStore.access_token)
        )
        data.plans = response.data.plans
        data.store.isLoading = false
    } catch (error) {
        data.store.isLoading = false
        console.log(error)
    }
}

//once the component is mounted we get all the plans
onMounted(() => {
    if (authStore?.user?.number_of_hearts > 0) {
        router.push('/')
    } else {
        fetchPlans()
    }
})

//once the component is unmounted we remove the chosen plan
onUnmounted(() => authStore.setChosenPlan(null))

</script>

<style scoped></style>