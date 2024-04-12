<script setup>
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from "@headlessui/vue";
import {PhotoIcon} from "@heroicons/vue/24/solid/index.js";
import {XMarkIcon} from "@heroicons/vue/24/outline/index.js";
import {useCart} from "../../../composables/useCart.js";
import {computed, onMounted} from "vue";

const cart = useCart()
const items = computed(() => cart.cart.value)
const open = computed(() => cart.open.value)

onMounted(() => {
    cart.getCart()
})
</script>

<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="cart.open.value = false">
            <TransitionChild as="template" enter="ease-in-out duration-500" enter-from="opacity-0"
                             enter-to="opacity-100" leave="ease-in-out duration-500" leave-from="opacity-100"
                             leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
            </TransitionChild>

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <TransitionChild as="template"
                                         enter="transform transition ease-in-out duration-500 sm:duration-700"
                                         enter-from="translate-x-full" enter-to="translate-x-0"
                                         leave="transform transition ease-in-out duration-500 sm:duration-700"
                                         leave-from="translate-x-0" leave-to="translate-x-full">
                            <DialogPanel class="pointer-events-auto relative w-screen max-w-md">
                                <TransitionChild as="template" enter="ease-in-out duration-500" enter-from="opacity-0"
                                                 enter-to="opacity-100" leave="ease-in-out duration-500"
                                                 leave-from="opacity-100" leave-to="opacity-0">
                                    <div class="absolute left-0 top-0 -ml-8 flex pr-2 pt-4 sm:-ml-10 sm:pr-4">
                                        <button type="button"
                                                class="relative rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                                                @click="open = false">
                                            <span class="absolute -inset-2.5"/>
                                            <span class="sr-only">Close panel</span>
                                            <XMarkIcon class="h-6 w-6" aria-hidden="true"/>
                                        </button>
                                    </div>
                                </TransitionChild>
                                <div class="flex h-full flex-col overflow-y-scroll bg-white py-6 shadow-xl">
                                    <div class="px-4 sm:px-6">
                                        <DialogTitle class="text-base font-semibold leading-6 text-gray-900">
                                            Shopping Cart
                                        </DialogTitle>
                                    </div>
                                    <div class="relative mt-6 flex-1 px-4 sm:px-6">
                                        <div class="mt-8">
                                            <div class="flow-root">
                                                <ul role="list" class="-my-6 divide-y divide-gray-200">
                                                    <li v-for="item in items" :key="item.id" class="flex py-6">
                                                        <div
                                                            class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                            <img v-if="item.product.photos.length"
                                                                 :src="item.product.photos[0]?.original_url"
                                                                 :alt="item.product.photos[0]?.original_url"
                                                                 class="h-full w-full object-cover object-center"/>
                                                        </div>

                                                        <div class="ml-4 flex flex-1 flex-col">
                                                            <div>
                                                                <div
                                                                    class="flex justify-between text-base font-medium text-gray-900">
                                                                    <h3>
                                                                        <a>{{ item.product.name }}</a>
                                                                    </h3>
                                                                    <p class="ml-4">{{
                                                                            item.product.formatted_price
                                                                        }}</p>
                                                                </div>
                                                                <p class="mt-1 text-sm text-gray-500">{{
                                                                        item.product.description
                                                                    }}</p>
                                                            </div>
                                                            <div class="flex flex-1 items-end justify-between text-sm">
                                                                <p class="text-gray-500">Qty {{ item.quantity }}</p>

                                                                <div class="flex">
                                                                    <button type="button"
                                                                            @click.prevent="cart.removeCart(item.id)"
                                                                            class="font-medium text-indigo-600 hover:text-indigo-500">
                                                                        Remove
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                            <p>Subtotal</p>
                                            <p>
                                                {{
                                                    (cart.totalAmount.value).toLocaleString('en-US', {
                                                        style: 'currency',
                                                        currency: 'USD',
                                                    })
                                                }}
                                            </p>
                                        </div>
                                        <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at
                                            checkout.</p>
                                        <div class="mt-6">
                                            <a href="#"
                                               class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">Checkout</a>
                                        </div>
                                        <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                                            <p>
                                                or{{ ' ' }}
                                                <button type="button"
                                                        class="font-medium text-indigo-600 hover:text-indigo-500"
                                                        @click="open = false">
                                                    Continue Shopping
                                                    <span aria-hidden="true"> &rarr;</span>
                                                </button>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<style scoped>

</style>
