<script setup>
import {defineEmits, defineProps} from 'vue'

const props = defineProps({
    showEdit: {
        type: Boolean
    },
    item: {
        type: Object
    }
})
const emits = defineEmits(['close', 'update:value'])
</script>

<template>
    <div v-if="showEdit" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-96 max-w-full shadow-lg transform transition-all duration-300">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b-2 border-gray-200 pb-4">
                <h2 class="text-2xl font-semibold">Update Product Information</h2>
                <button @click="emits('close')" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="mt-6 space-y-4">
                <form>
                    <div class="flex flex-col">
                        <label for="name" class="hidden">Full Name</label>
                        <input type="name" name="name" id="name" placeholder="Full Name"
                               class="w-100 mt-2 py-3 px-3 rounded-lg bg-white dark:bg-gray-800 border border-gray-400 dark:border-gray-700 text-gray-800 dark:text-gray-50 font-semibold focus:border-blue-500 focus:outline-none"/>
                    </div>

                    <div class="flex flex-col mt-2">
                        <label for="email" class="hidden">Email</label>
                        <input type="email" name="email" id="email" placeholder="Email"
                               class="w-100 mt-2 py-3 px-3 rounded-lg bg-white dark:bg-gray-800 border border-gray-400 dark:border-gray-700 text-gray-800 dark:text-gray-50 font-semibold focus:border-blue-500 focus:outline-none"/>
                    </div>

                    <div class="flex flex-col mt-2">
                        <label for="tel" class="hidden">Number</label>
                        <input type="tel" name="tel" id="tel" placeholder="Telephone Number"
                               class="w-100 mt-2 py-3 px-3 rounded-lg bg-white dark:bg-gray-800 border border-gray-400 dark:border-gray-700 text-gray-800 dark:text-gray-50 font-semibold focus:border-blue-500 focus:outline-none"/>
                    </div>

                    <button type="submit"
                            class="w-100 md:w-32 bg-blue-600 dark:bg-gray-100 text-white dark:text-gray-800 font-bold py-3 px-6 rounded-lg mt-4 hover:bg-blue-500 dark:hover:bg-gray-200 transition ease-in-out duration-300">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
