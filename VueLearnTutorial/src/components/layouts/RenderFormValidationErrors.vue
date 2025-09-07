<template>
    <div class="row my-3">
        <div class="col-md-8 mx-auto">
            <ul class="list-group my-2" v-for="(errors, index) in authStore.validationErrors" :key="index">
                <li class="list-group-item bg-danger text-white mb-1 rounded" v-for="(error, index) in errors"
                    :key="index">
                    {{ error }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { useAuthStore } from '../../stores/useAuthStore'

//define the store
const authStore = useAuthStore()
</script>

<style scoped></style>