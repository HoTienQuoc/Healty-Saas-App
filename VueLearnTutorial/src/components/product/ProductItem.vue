<template>
    <div class="col-md-5">
        <div class="card bg-light">
            <div class="card-body">
                <!-- search box -->
                <SearchBox />
                <div class="card" v-if="productStore.product">
                    <div class="card-body">
                        <div class="d-flex justify-content-start">
                            <img :src="productStore.product.image" :alt="productStore.product.name" class="rounded me-2"
                                height="50" width="50" />
                            <div>
                                <div class="d-flex flex-column">
                                    <strong>
                                        {{ productStore.product.name }}
                                    </strong>
                                    <div class="d-flex align-items-center">
                                        <strong class="me-1">
                                            {{ productStore.product.score }}/100
                                        </strong>
                                        <span :style="{
                                            width: '0.6rem',
                                            height: '0.6rem',
                                            backgroundColor: `${productStore.product.score >= 50 ? 'green' : productStore.product.score >= 30 ? 'orange' : 'red'}`,
                                            borderRadius: '50%'
                                        }">
                                        </span>
                                    </div>
                                </div>
                                <span>
                                    {{ productStore.product.score >= 50 ? 'Good' : productStore.product.score >= 30 ?
                                    'Poor' : 'Bad' }}
                                </span>
                            </div>
                        </div>
                        <p class="my-3">
                            {{ productStore.product.description }}
                        </p>
                        <ProductPositives />
                        <ProductNegatives />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useProductStore } from "../../stores/useProductStore"
import ProductPositives from "./ProductPositives.vue"
import ProductNegatives from "./ProductNegatives.vue"
import SearchBox from "../search/SearchBox.vue"

//define the store
const productStore = useProductStore()

</script>

<style scoped></style>