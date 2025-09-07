// stores/useProductStore.ts

import { defineStore } from 'pinia'
import axios from 'axios'
import { BASE_URL, headersConfig } from '../helpers/config'
import { useAuthStore } from './useAuthStore'

// Define types
interface Product {
    id: number
    name: string
    description?: string
    // Add more fields if needed
}

export const useProductStore = defineStore('product', {
    state: () => ({
        product: null as Product | null,
        isLoading: false,
        error: ''
    }),
    actions: {
        async fetchProductById(productId: number | string) {
            this.error = ''
            this.product = null
            this.isLoading = true

            const authStore = useAuthStore()

            try {
                const response = await axios.get(`${BASE_URL}/find/product/${productId}`, headersConfig(authStore.access_token))
                authStore.decrementUserHearts()
                this.product = response.data.data
                this.addProductToUserHistory()
            } catch (error: any) {
                if (error?.response?.status === 404) {
                    this.error = 'Sorry I cannot rate this product!'
                }
                console.error(error)
            } finally {
                this.isLoading = false
            }
        },

        async fetchProductByName(name: string) {
            this.error = ''
            this.product = null
            this.isLoading = true

            const authStore = useAuthStore()

            try {
                const response = await axios.get(`${BASE_URL}/search/product/${name}`, headersConfig(authStore.access_token))
                authStore.decrementUserHearts()
                this.product = response.data.data
                this.addProductToUserHistory()
            } catch (error: any) {
                if (error?.response?.status === 404) {
                    this.error = 'Sorry, I cannot find the product you are searching for!'
                }
                console.error(error)
            } finally {
                this.isLoading = false
            }
        },

        async addProductToUserHistory() {
            const authStore = useAuthStore()

            if (!this.product) return

            try {
                const response = await axios.post(
                    `${BASE_URL}/add/history/`,
                    { product_id: this.product.id },
                    headersConfig(authStore.access_token)
                )
                authStore.setUser(response.data.data)
            } catch (error) {
                console.error(error)
            }
        }
    }
})
