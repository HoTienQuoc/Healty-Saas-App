<template>
    <div v-if="productStore.product.positives.length">
        <h5> Positives </h5>
        <ul>
            <li class="d-flex flex-column" v-for="positive in productStore.product.positives" :key="positive.id">
                <strong>
                    {{ positive.name }}
                </strong>
                <p>
                    {{ positive.description }}
                </p>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { useProductStore } from "../../stores/useProductStore"

//define the store
const productStore = useProductStore()
</script>

<style scoped></style>