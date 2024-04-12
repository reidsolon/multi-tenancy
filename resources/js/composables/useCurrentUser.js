import {ref} from "vue";
import isEmpty from "lodash/isEmpty";

const current_user = ref({})

export const useCurrentUser = () => {

    const loading = ref(false)

    function isLoggedIn() {
        return !isEmpty(current_user.value)
    }

    async function getCurrentUser(path = '/me') {
        try {
            loading.value = true
            const {data} = await axios.get(path)

            current_user.value = data.data
        } catch (e) {
            if (e.response.status === 401) {
                console.log(e)
            }
        } finally {
            loading.value = false
        }
    }

    async function logout(path = '/logout', cb = () => {
    }) {
        try {
            loading.value = true
            await axios.post(path)
            current_user.value = null
            cb()
        } catch (e) {

        } finally {
            loading.value = false
        }
    }

    return {
        getCurrentUser,
        isLoggedIn,
        current_user,
        logout
    }
}
