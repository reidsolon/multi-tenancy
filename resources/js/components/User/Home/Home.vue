<script setup>
import {useHome} from "../../../composables/useHome.js";
import {onBeforeMount, computed} from "vue";
import Product from './Product.vue'

const home = useHome()
const products = computed(() => home.rows.value)

onBeforeMount(() => {
    home.getData('/products')
})
</script>

<template>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Available Products</h2>
            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                <Product :product="product" v-for="product in products" :key="product.id" class="group relative">
                </Product>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
