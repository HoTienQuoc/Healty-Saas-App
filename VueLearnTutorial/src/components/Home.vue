<template>
    <div class="card border border-light border-4 rounded shadow-sm my-3">
        <div class="card-body">
            <div class="container">
                <Navbar />
                <div class="row my-5">
                    <div class="col-md-7 mb-2">
                        <div class="row my-3">
                            <div class="col-md-8 mx-auto">
                                <div class="bg-danger text-white mb-1 rounded p-2 text-center"
                                    v-if="productStore.error">
                                    <!-- error -->
                                    {{ productStore.error }}
                                </div>
                            </div>
                        </div>
                        <div class="card bg-light">
                            <div class="card-body">
                                <qrcode-capture @detect="onDetect" @change="onFileChange" :key="data.fileInputKey"
                                    :disabled="authStore?.user?.number_of_hearts === 0" />
                            </div>
                        </div>
                        <div class="my-4 d-flex justify-content-center align-items-center" v-if="data.image">
                            <div :class="{ scan: productStore.isLoading }">
                                <img :src="data.image" alt="selected image" class="rounded" height="300" width="200" />
                            </div>
                        </div>
                    </div>
                    <ProductItem />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive } from "vue"
import { QrcodeCapture } from "vue-qrcode-reader"
import { useProductStore } from "../stores/useProductStore"
import { useAuthStore } from "../stores/useAuthStore"
import ProductItem from './product/ProductItem.vue'
import Navbar from './layouts/Navbar.vue'

//define the store
const productStore = useProductStore()
const authStore = useAuthStore()

//define the data object
const data = reactive({
    image: null,
    fileInputKey: 0,
})

//detect the qr code on the image
const onDetect = (detectedCodes) => {
    if (detectedCodes.map((code) => code.rawValue).toString() !== "") {
        //send the request
        productStore.fetchProductById(
            detectedCodes.map((code) => code.rawValue).toString()
        )
        clearInputFile()
    } else {
        //display an error
        productStore.error = "Sorry i can not rate this product"
        clearInputFile()
    }
}

//preview the image that the user has chosen
const onFileChange = (e) => {
    data.image = null
    productStore.error = ""
    const file = e.target.files[0]
    if (file) {
        data.image = URL.createObjectURL(file)
    }
}

//clear the input file
const clearInputFile = () => {
    setTimeout(() => {
        data.image = null
        data.fileInputKey++
    }, 2000)
}
</script>

<style scoped>
.scan {
    width: 18.75rem;
    position: relative;
    opacity: 0.5;
    text-align: center;
}

.scan::before {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    width: 1.3rem;
    background: #c81818;
    box-shadow: 0 0 5rem 1.3rem #c81818;
    clip-path: inset(0);
    animation: x 0.5s ease-in-out infinite alternate, y 1s ease-in-out infinite;
}

@keyframes x {
    to {
        transform: translateX(-100%);
        left: 100%;
    }
}

@keyframes y {
    33% {
        clip-path: inset(0 0 0 -100px);
    }

    50% {
        clip-path: inset(0 0 0 0);
    }

    83% {
        clip-path: inset(0 -100px 0 0);
    }
}
</style>