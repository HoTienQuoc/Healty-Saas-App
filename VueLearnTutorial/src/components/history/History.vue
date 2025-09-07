<template>
    <div class="card border border-light border-4 rounded shadow-sm my-3">
        <div class="card-body">
            <div class="container">
                <Navbar />
                <div class="row my-5">
                    <div class="col-md-10 mx-auto">
                        <div class="row"
                            v-if="authStore?.user?.histories?.length"
                        >
                            <div class="col-md-4 mb-2"
                                v-for="history in authStore.user.histories"
                                :key="history.id"
                            >
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-start">
                                            <img
                                                :src="history.product.product_image"
                                                :alt="history.product.name"
                                                class="rounded me-2"
                                                height="50"
                                                width="50"
                                            />
                                            <div>
                                                <div class="d-flex flex-column">
                                                    <strong>
                                                        {{ history.product.name }}
                                                    </strong>
                                                    <div class="d-flex align-items-center">
                                                        <strong class="me-1">
                                                            {{ history.product.score }}/100
                                                        </strong>
                                                        <span
                                                            :style="{
                                                                width: '0.6rem',
                                                                height: '0.6rem',
                                                                backgroundColor: `${history.product.score >= 50 ? 'green' : history.product.score >= 30 ? 'orange' : 'red' }`,
                                                                borderRadius: '50%'
                                                            }"
                                                        >
                                                        </span>
                                                    </div>
                                                </div>
                                                <span>
                                                    {{history.product.score >= 50 ? 'Good' : history.product.score >= 30 ? 'Poor' : 'Bad' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-else>
                            <div class="col-md-6 mx-auto">
                                <div class="alert alert-info">
                                    <i class="bi bi-clock-history"></i> Your history is empty
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { useAuthStore } from "../../stores/useAuthStore";
    import Navbar from "../layouts/Navbar.vue"

    //define the store
    const authStore = useAuthStore()
</script>

<style scoped>
</style>