<script setup>
import {useDatatable} from "../../composables/useDatatable.js";
import {nextTick, onMounted, computed, ref, watch} from "vue";
import DataTable from "../DataTable.vue";
import Create from './Create.vue'
import Dialog from "../Dialog.vue";

const datatable = useDatatable();
const headers = ref([
    {
        name: 'Domain',
        field: 'domain',
    },
    {
        name: 'id',
        field: 'id',
    },
    {
        name: 'Database',
        field: 'tenancy_db_name',
    },
    {
        name: 'Date of creation',
        field: 'created_at',
    },
    {
        name: 'Action',
        field: 'action',
    },
])
const loading = ref(false)
const data = computed(() => datatable.rows.value)
const meta = computed(() => datatable.pagination.value)
const open = ref(false)
const selectedItem = ref(null)
const deleteDialog = ref(false)

async function handleDelete() {
    try {
        loading.value = true
        await axios.delete(`/tenants/${selectedItem.value?.id}`)
        datatable.getData('/tenants/list', meta.value.current_page)
        selectedItem.value = null
        deleteDialog.value = false
    } catch (e) {

    } finally {
        loading.value = false
    }
}

onMounted(async () => {
    await nextTick()
    datatable.getData('/tenants/list')
})
</script>
<template>
    <div
        class="relative flex flex-col min-w-0 mb-4 lg:mb-0 break-words bg-gray-50 dark:bg-gray-800 w-full shadow-lg rounded">
        <Dialog @close="deleteDialog = false" :open="deleteDialog"
                @confirm="handleDelete"
                :loading="loading"
                title="Delete Tenant"
                description="Are you sure you want to delete this tenant? Data will be permanently removed. This action cannot be undone."/>
        <Create @new="datatable.getData('/tenants/list', meta.current_page)" :open="open"
                panel-title="Create new tenant" @close="open = false"/>
        <div class="rounded-t mb-0 px-0 border-0">
            <div class="flex flex-wrap items-center px-4 py-2">
                <div class="relative w-full max-w-full flex-grow flex-1">
                    <h3 class="font-semibold text-base text-gray-900 dark:text-gray-50">Tenants</h3>
                </div>
                <div class="relative w-full max-w-full flex-grow flex-1 text-right">
                    <button
                        @click.prevent="open = true"
                        class="bg-blue-500 dark:bg-gray-100 text-white active:bg-blue-600 dark:text-gray-800 dark:active:text-gray-700 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button">Create
                    </button>
                </div>
            </div>
            <div class="relative">
                <div class="absolute bg-white bg-opacity-10 z-10 h-full w-full flex items-center justify-center" v-if="loading || datatable.fetching.value">
                    <div class="flex items-center">
                        <span class="text-3xl mr-4">Loading</span>
                        <svg class="animate-spin h-8 w-8 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </div>
                <DataTable @next="datatable.getData('/tenants/list', meta.current_page + 1)"
                           @prev="datatable.getData('/tenants/list', meta.current_page - 1)" :items="data" :meta="meta"
                           :headers="headers">
                    <template #domain="{ item }">
                        {{ item.domains[0]?.domain }}
                    </template>
                    <template #id="{ item }">
                        {{ item.id }}
                    </template>
                    <template #tenancy_db_name="{ item }">
                        {{ item.tenancy_db_name }}
                    </template>
                    <template #created_at="{ item }">
                        {{ item.created_at }}
                    </template>
                    <template #action="{ item }">
                        <button type="button"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                @click="selectedItem = item; deleteDialog = true" ref="cancelButtonRef">Delete
                        </button>
                    </template>
                </DataTable>
            </div>
        </div>
    </div>
</template>
<style scoped>

</style>
