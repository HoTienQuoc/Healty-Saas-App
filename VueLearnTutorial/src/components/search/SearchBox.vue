<template>
    <div class="card mb-3">
        <div class="card-body">
            <form class="row">
                <div class="col-md-11 mx-auto">
                    <input type="search" class="form-control" placeholder="Search..." @change="searchForProductByName"
                        v-model="data.name" :disabled="authStore?.user?.number_of_hearts === 0">
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { reactive } from "vue"
import { useAuthStore } from "../../stores/useAuthStore"
import { useProductStore } from "../../stores/useProductStore"

//define the store
const productStore = useProductStore()
const authStore = useAuthStore()

//define the data object
const data = reactive({
    name: ''
})

//define the search function
const searchForProductByName = () => {
    productStore.fetchProductByName(data.name)
    data.name = ''
}
</script>

<style scoped></style>