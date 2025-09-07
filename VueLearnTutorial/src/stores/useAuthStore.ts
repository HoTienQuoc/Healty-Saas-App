// stores/useAuthStore.ts

import { defineStore } from 'pinia'
import axios from 'axios'
import { BASE_URL, headersConfig } from '../helpers/config'

// Define types
interface User {
    id: number
    name: string
    email: string
    hearts: number
    // Add more fields as necessary
}

interface ValidationErrors {
    [key: string]: string[]
}

export const useAuthStore = defineStore('user', {
    state: () => ({
        user: null as User | null,
        isLoading: false,
        isLoggedIn: false,
        access_token: '',
        validationErrors: null as ValidationErrors | null,
        chosenPlan: null as string | null
    }),
    persist: true,
    actions: {
        setIsLoggedIn() {
            this.isLoggedIn = true
        },
        setUser(user: User) {
            this.user = user
        },
        setToken(token: string) {
            this.access_token = token
        },
        clearAuthData() {
            this.isLoggedIn = false
            this.user = null
            this.access_token = ''
        },
        setFormValidationErrors(errors: ValidationErrors) {
            this.validationErrors = errors
        },
        clearValidationErrors() {
            this.validationErrors = null
        },
        async decrementUserHearts() {
            try {
                const response = await axios.get(`${BASE_URL}/user/decrement/hearts`, headersConfig(this.access_token))
                this.user = response.data.user
            } catch (error) {
                console.error(error)
            }
        },
        setChosenPlan(plan: string) {
            this.chosenPlan = plan
        },
    }
})
