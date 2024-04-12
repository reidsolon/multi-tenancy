<script setup>
import {computed, reactive, defineProps, ref} from "vue";
import {useForm} from "../../composables/useForm.js";

const props = defineProps({
    redirectUrl: {
        type: String,
        default: '/tenants'
    },
    registerPath: {
        type: String,
        default: '/register',
    },
})

const loading = ref(false)
const form = useForm({
    email: '',
    name: '',
    password_confirmation: '',
    password: ''
})
const errors = ref({})
const buttonText = computed(() => loading.value ? 'Signing you up...' : 'Sign Up')

async function submit(e) {
    e.preventDefault();
    try {
        loading.value = true
        const {data} = await axios.post(props.registerPath, {
            email: form.email,
            name: form.name,
            password_confirmation: form.password_confirmation,
            password: form.password
        })

        window.location.href = props.redirectUrl
    } catch (err) {
        if (err.response.status === 422) {
            form.$setErrors(err.response.data.errors)
        }
    } finally {
        loading.value = false
    }
}
</script>

<template>
    <div>
        <form class="space-y-6" @submit.prevent="submit" method="POST">
            <h2 class="mb-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign up an
                account</h2>
            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                <div class="mt-2">
                    <input
                        @input="form.$clearError('email')"
                        :class="{'border-pink-500 text-pink-600' : form.$hasError('email'), 'border-0' : !form.$hasError('email')}"
                        v-model="form.email" id="email" name="email" type="email" autocomplete="email" required=""
                        class="invalid:border-pink-500 invalid:text-pink-600 focus:invalid:border-pink-500 focus:invalid:ring-pink-500 border-red-600 block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                    <p class="mt-2 text-pink-600 text-sm" v-for="error in form.$getError('email')" :key="error">
                        {{ error }}
                    </p>
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                <div class="mt-2">
                    <input
                        @input="form.$clearError('name')"
                        :class="{'border-pink-500 text-pink-600' : form.$hasError('email'), 'border-0' : !form.$hasError('email')}"
                        v-model="form.name" id="name" name="name" type="text" autocomplete="email" required=""
                        class="invalid:border-pink-500 invalid:text-pink-600 focus:invalid:border-pink-500 focus:invalid:ring-pink-500 border-red-600 block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                    <p class="mt-2 text-pink-600 text-sm" v-for="error in form.$getError('name')" :key="error">
                        {{ error }}
                    </p>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                </div>
                <div class="mt-2">
                    <input v-model="form.password" id="password" name="password" type="password"
                           autocomplete="current-password" required=""
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                    <p class="mt-2 text-pink-600 text-sm" v-for="error in form.$getError('password')" :key="error">
                        {{ error }}
                    </p>
                </div>
            </div>
            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Confirm
                        Password</label>
                </div>
                <div class="mt-2">
                    <input v-model="form.password_confirmation" id="password_confirmation" name="password_confirmation" type="password"
                           autocomplete="current-password" required=""
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                    <p class="mt-2 text-pink-600 text-sm" v-for="error in form.$getError('password_confirmation')"
                       :key="error">
                        {{ error }}
                    </p>
                </div>
            </div>

            <div>
                <button type="submit"
                        :disabled="loading"
                        class="disabled:opacity-30 flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    {{ buttonText }}
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
