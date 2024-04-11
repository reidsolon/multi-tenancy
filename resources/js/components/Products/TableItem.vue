<script setup>
import Edit from './Edit.vue'
import {defineProps, ref} from 'vue'

const props = defineProps({
    item: {
        type: Object
    }
})
const showEdit = ref(false)
const showDelete = ref(false)
</script>

<template>
    <Edit :item="item" :show-edit="showEdit" @close="showEdit=false"/>
    <tr class="text-gray-700 dark:text-gray-100">
        <th class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
            Image
        </th>
        <td class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
            {{ item.name }}
        </td>
        <td class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
            {{ item.formatted_price }}
        </td>
        <td class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
            {{ item.description }}
        </td>
        <td class="text-end border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
            <button
                @click.prevent="showEdit = true"
                class="bg-yellow-500 dark:bg-gray-100 text-white active:bg-blue-600 dark:text-gray-800 dark:active:text-gray-700 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                type="button">Edit
            </button>
            <button
                class="bg-red-500 dark:bg-gray-100 text-white active:bg-blue-600 dark:text-gray-800 dark:active:text-gray-700 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                type="button">Delete
            </button>
        </td>
    </tr>
</template>

<style scoped>

</style>
