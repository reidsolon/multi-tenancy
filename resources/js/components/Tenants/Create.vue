<script setup>
import {defineProps, defineEmits, ref, watch} from 'vue'
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from '@headlessui/vue'
import {XMarkIcon} from '@heroicons/vue/24/outline'
import {useForm} from "../../composables/useForm.js";

const props = defineProps({
    open,
    panelTitle: {
        type: String,
        default: 'Title'
    }
})

const loading = ref(false)
const isSuccess = ref(false)
const emits = defineEmits(['close', 'new'])
const form = useForm({
    domain: '',
    email: '',
    password: '',
})

async function submit(e) {
    e.preventDefault();
    try {
        loading.value = true
        await axios.post('/tenants', {
            domain: form.domain,
            email: form.email,
            password: form.password
        })
        emits('new')
        form.$clearErrors()
        form.$reset()
        isSuccess.value = true
    } catch (err) {
        if (err.response.status === 422) {
            form.$setErrors(err.response.data.errors)
        }
    } finally {
        loading.value = false
    }
}

watch(
    () => isSuccess.value,
    (val) => {
        if (val) {
            setTimeout(() => isSuccess.value = false, 4000)
        }
    }
)
</script>

<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="emits('close')">
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
                                            {{ panelTitle }}
                                        </DialogTitle>
                                    </div>
                                    <div class="relative mt-6 flex-1 px-4 sm:px-6">
                                        <div v-if="isSuccess"
                                             class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md"
                                             role="alert">
                                            <div class="flex">
                                                <div class="py-1">
                                                    <svg class="fill-current h-6 w-6 text-teal-500 mr-4"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path
                                                            d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-bold">Tenant created successfully</p>
                                                    <p class="text-sm">Subdomain and database is ready</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Your content -->
                                        <form @submit.prevent="submit">
                                            <div class="space-y-12">
                                                <div class="border-b border-gray-900/10 pb-12">
                                                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 ">
                                                        <div class="sm:col-span-4">
                                                            <label for="username"
                                                                   class="block text-sm font-medium leading-6 text-gray-900">Domain
                                                                Name <span class="text-red-400">*</span></label>
                                                            <div class="mt-2">
                                                                <div
                                                                    class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                                                    <input v-model="form.domain" type="text"
                                                                           name="username" id="username"
                                                                           autocomplete="username"
                                                                           class="invalid:border-red-50 block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                                           placeholder="tenant1"/>
                                                                    <span
                                                                        class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">.this-app's-domain.com</span>
                                                                </div>
                                                                <p class="mt-2 text-pink-600 text-sm"
                                                                   v-for="error in form.$getError('domain')"
                                                                   :key="error">
                                                                    {{ error }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="sm:col-span-4">
                                                            <label for="username"
                                                                   class="block text-sm font-medium leading-6 text-gray-900">Admin
                                                                Username <span
                                                                    class="text-gray-400">(optional)</span></label>
                                                            <div class="mt-2">
                                                                <div
                                                                    class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                                                    <input type="text" name="email" id="email"
                                                                           v-model="form.email"
                                                                           autocomplete="email"
                                                                           class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                                           placeholder="admin@gmail.com"/>
                                                                </div>
                                                                <div>
                                                                    <p class="mt-2 text-gray-400 text-sm">If not filled,
                                                                        system will auto-generate</p>
                                                                </div>
                                                                <div>
                                                                    <p class="mt-2 text-pink-600 text-sm"
                                                                       v-for="error in form.$getError('email')"
                                                                       :key="error">
                                                                        {{ error }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="sm:col-span-4">
                                                            <label for="username"
                                                                   class="block text-sm font-medium leading-6 text-gray-900">Admin
                                                                Password <span
                                                                    class="text-gray-400">(optional)</span></label>
                                                            <div class="mt-2">
                                                                <div
                                                                    class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                                                    <input type="password" name="password" id="password"
                                                                           v-model="form.password"
                                                                           autocomplete="password"
                                                                           class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                                           placeholder="Any password"/>
                                                                </div>
                                                                <div>
                                                                    <p class="mt-2 text-gray-400 text-sm">If not filled,
                                                                        system will auto-generate</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-6 flex items-center justify-end gap-x-6">
                                                <button type="button"
                                                        v-if="!loading"
                                                        class="text-sm font-semibold leading-6 text-gray-900">Cancel
                                                </button>
                                                <button type="submit"
                                                        :disabled="loading"
                                                        class="disabled:opacity-30 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                    Save
                                                </button>
                                            </div>
                                        </form>
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
