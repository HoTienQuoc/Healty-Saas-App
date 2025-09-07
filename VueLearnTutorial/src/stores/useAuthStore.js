import { defineStore } from 'pinia'
import axios from 'axios'
import { BASE_URL, headersConfig } from '../helpers/config'

export const useAuthStore = defineStore('user', {
    state: () => ({
        user: null,
        isLoading: false,
        isLoggedIn: false,
        access_token: '',
        validationErrors: null,
        chosenPlan: null
    }),
    persist: true,
    actions: {
        setIsLoggedIn() {
            this.isLoggedIn = true
        },
        setUser(user) {
            this.user = user
        },
        setToken(token) {
            this.access_token = token
        },
        clearAuthData() {
            this.isLoggedIn = false;
            this.user = null
            this.access_token = ''
        },
        setFormValidationErrors(errors) {
            this.validationErrors = errors
        },
        clearValidationErrors() {
            this.validationErrors = null
        },
        async decrementUserHearts() {
            try {
                const response = await axios.get(`${BASE_URL}/user/decrement/hearts`,
                    headersConfig(this.access_token)
                )
                this.user = response.data.user
            } catch (error) {
                console.log(error)
            }
        },
        setChosenPlan(plan) {
            this.chosenPlan = plan
        },
    }
})