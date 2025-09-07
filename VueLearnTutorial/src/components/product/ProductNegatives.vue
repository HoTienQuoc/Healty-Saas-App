<template>
    <div v-if="productStore.product.negatives.length">
        <h5> Negatives </h5>
        <ul>
            <li class="d-flex flex-column" v-for="negative in productStore.product.negatives" :key="negative.id">
                <strong>
                    {{ negative.name }}
                </strong>
                <p>
                    {{ negative.description }}
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