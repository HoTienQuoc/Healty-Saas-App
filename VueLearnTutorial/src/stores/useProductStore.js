import { defineStore } from 'pinia'
import axios from 'axios'
import { BASE_URL, headersConfig } from '../helpers/config'
import { useAuthStore } from './useAuthStore'

//define the auth store
const authStore = useAuthStore()

export const useProductStore = defineStore('product', {
    state: () => ({
        product: null,
        isLoading: false,
        error: ''
    }),
    actions: {
        async fetchProductById(product) {
            this.error = ''
            this.product = null
            this.isLoading = true
            try {
                const response = await axios.get(`${BASE_URL}/find/product/${product}`,
                    headersConfig(authStore.access_token)
                )
                authStore.decrementUserHearts()
                this.product = response.data.data
                this.addProductToUserHistory()
                this.isLoading = false
            } catch (error) {
                this.isLoading = false
                if(error?.response?.status === 404) {
                    this.error = 'Sorry i can not rate this product!'
                }
                console.log(error)
            }
        },
        async fetchProductByName(name) {
            this.error = ''
            this.product = null
            this.isLoading = true
            try {
                const response = await axios.get(`${BASE_URL}/search/product/${name}`,
                    headersConfig(authStore.access_token)
                )
                authStore.decrementUserHearts()
                this.product = response.data.data
                this.addProductToUserHistory()
                this.isLoading = false
            } catch (error) {
                this.isLoading = false
                if(error?.response?.status === 404) {
                    this.error = 'Sorry i can not find the product you are searching for!'
                }
                console.log(error)
            }
        },
        async addProductToUserHistory() {
            try {
                const response = await axios.post(`${BASE_URL}/add/history/`, 
                    {
                        product_id: this.product.id
                    },
                    headersConfig(authStore.access_token)
                )
                authStore.setUser(response.data.data)
            } catch (error) {
                console.log(error)
            }
        }
    }
})