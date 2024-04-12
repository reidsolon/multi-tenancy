<script setup>
import {defineProps, defineEmits} from 'vue'
import Table from "./Tenants/Table.vue";

const props = defineProps({
    headers: {
        type: Array,
        default: () => ([])
    },
    meta: {
        type: Object,
        default: () => ({
            current_page: 0,
            last_page: 1,
            total: 0,
            per_page: 10,
            from: 1,
            to: 1,
            next_link: null,
            prev_link: null,
        })
    },
    items: {
        type: Array,
        default: () => ([])
    }
})
const emits = defineEmits(['next', 'prev'])
</script>

<template>
    <div>
        <div class="block w-full overflow-x-auto">
            <table class="items-center w-full bg-transparent border-collapse">
                <thead>
                <tr>
                    <th :key="header" v-for="header in headers"
                        class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                        {{ header.name }}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-gray-700 dark:text-gray-100" v-for="item in items" :key="item.id">
                    <td class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                        v-for="slot in headers" :key="slot.field + '__SlotItem'">
                        <slot :name="slot.field" :item="item"></slot>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div
            class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
        <span class="flex items-center col-span-3"> Showing {{ meta.from ?? 0 }}-{{ meta.to ?? 0 }} of {{
                meta.total ?? 0
            }} </span>
            <span class="col-span-2"></span>
            <!-- Pagination -->
            <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                <nav aria-label="Table navigation">
                  <ul class="inline-flex items-center">
                    <li>
                      <button @click="emits('prev')" :disabled="!(meta.current_page > 1)" class="disabled:opacity-30 px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                              aria-label="Previous">
                        <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                          <path
                              d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                              clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                      </button>
                    </li>
                    <li>
                      <button @click="emits('next')" :disabled="!(meta.current_page <= 1)" class="disabled:opacity-30 px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
                              aria-label="Next">
                        <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                          <path
                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                              clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                      </button>
                    </li>
                  </ul>
                </nav>
                </span>
        </div>
    </div>
</template>

<style scoped>

</style>
