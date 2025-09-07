<template>
    <div>
        <div ref="cardContainer" class="card"></div>
        <button class="btn btn-sm btn-dark" @click="subscribe" :disabled="loading">Subscribe</button>
    </div>
</template>

<script setup>
//imports
import { ref, onMounted } from 'vue'
import { loadStripe } from '@stripe/stripe-js'
import axios from "axios"
import { useAuthStore } from '../../stores/useAuthStore'
import { useRouter } from 'vue-router'
import { useToast } from 'vue-toastification'
import { BASE_URL, headersConfig } from '../../helpers/config'


//define the auth store
const authStore = useAuthStore()

//define the router
const router = useRouter()

//define the toast
const toast = useToast()

//define variables we need
const stripe = ref(null)
const elements = ref(null)
const card = ref(null)
const cardContainer = ref(null)
const loading = ref(false)

onMounted(async () => {
    try {
        stripe.value = await loadStripe('YOUR STRIPE PUBLISHABLE KEY HERE')
        elements.value = stripe.value.elements()

        card.value = elements.value.create('card')

        if (cardContainer.value) {
            card.value.mount(cardContainer.value) // Mounts the card input
        } else {
            console.error('Something went wrong try again.')
        }
    } catch (error) {
        console.error('Stripe initialization failed:', error)
    }
})

const subscribe = async () => {
    if (!stripe.value || !card.value) {
        console.error('Stripe has not been initialized properly.')
        return
    }

    const { paymentMethod, error } = await stripe.value.createPaymentMethod({
        type: 'card',
        card: card.value,
    })

    if (error) {
        console.error('Payment method creation failed:', error)
        return
    }

    //send request here
    loading.value = true

    try {
        const response = await axios.post(`${BASE_URL}/subscribe`,
            {
                plan_id: authStore?.chosenPlan?.id,
                payment_method: paymentMethod.id,
                price_id: authStore?.chosenPlan?.price_id,
            },
            headersConfig(authStore.access_token)
        )

        if (response.data.error) {
            toast.error('Something went wrong try again later!', {
                timeout: 2000
            });
            loading.value = false
        } else {
            authStore.setChosenPlan(null)
            toast.success(response.data.message, {
                timeout: 2000
            });
            loading.value = false
            router.push('/')
        }
    } catch (error) {
        loading.value = false
        console.log(error)
    }

}
</script>

<style>
.input {
    display: block;
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
}

.card {
    border: 1px solid #ccc;
    padding: 10px;
    margin-bottom: 10px;
}
</style>