import {computed, ref} from "vue";
import {findIndex} from "lodash";

const cart = ref([])
const totalAmount = computed(() => cart.value.map(e => e.amount).reduce((sum, a) => sum + a, 0))
const loading = ref(false)
const open = ref(false)

export const useCart = () => {
    const adding = ref(false)

    async function getCart() {
        try {
            loading.value = true
            const {data} = await axios.get('/cart')

            cart.value = data.data
        } catch (e) {
            if (e.response.status === 401) {
                console.log(e)
            }
        } finally {
            loading.value = false
        }
    }

    async function addToCart(id) {
        try {
            adding.value = true
            const {data} = await axios.post('/cart', {
                product_id: id
            })

            getCart()
        } catch (e) {
            if (e.response.status === 401) {
                console.log(e)
            }
        } finally {
            adding.value = false
        }
    }

    async function removeCart(id) {
        try {
            adding.value = true
            const {data} = await axios.delete('/cart/' + id)

            getCart()
        } catch (e) {
            if (e.response.status === 401) {
                console.log(e)
            }
        } finally {
            adding.value = false
        }
    }

    function inCart(id) {
        var index = findIndex(cart.value, {id})
        return index >= 0
    }

    return {
        getCart,
        cart,
        addToCart,
        removeCart,
        inCart,
        totalAmount,
        loading,
        adding,
        open
    }
}
