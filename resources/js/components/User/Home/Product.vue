<script setup>
import {computed, defineProps} from 'vue'
import {useCurrentUser} from "../../../composables/useCurrentUser.js";
import {useCart} from "../../../composables/useCart.js";
import {findIndex} from "lodash";

const props = defineProps({
    product: {
        type: Object,
        default: () => ({})
    }
})
const currentUser = useCurrentUser();
const cart = useCart()
const items = computed(() => cart.cart.value)
const adding = computed(() => cart.adding.value)
const inCart = computed(() => {
    var index = findIndex(items.value, {
        product_id: props.product?.id
    })

    return index >= 0
})

function submit() {
    if (!currentUser.isLoggedIn()) {
        alert('Login before adding to cart.')
        return null;
    }
}

</script>

<template>
    <div class="group">
        <div
            class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none lg:h-80">
            <img v-if="product.photos?.length" :src="product.photos[0].original_url"
                 :alt="product.photos[0].original_url"
                 class="h-full w-full object-cover object-center lg:h-full lg:w-full"/>
        </div>
        <div class="mt-4 flex justify-between">
            <div>
                <h3 class="text-sm text-gray-700">
                    <a :href="product.href">
                        {{ product.name }}
                    </a>
                </h3>
                <p class="mt-1 text-sm text-gray-500">{{ product.description }}</p>
            </div>
            <p class="text-sm font-medium text-gray-900">{{ product.formatted_price }}</p>
        </div>
        <button type="submit"
                v-if="!inCart"
                @click.prevent="cart.addToCart(product.id)"
                :disabled="adding"
                class="block mt-3 w-100 disabled:opacity-30 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            Add to cart
        </button>
        <button type="submit"
                v-else
                @click.prevent="cart.open.value = true"
                :disabled="adding"
                class="block mt-3 w-100 disabled:opacity-30 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            Update qty in cart
        </button>
    </div>
</template>

<style scoped>

</style>
