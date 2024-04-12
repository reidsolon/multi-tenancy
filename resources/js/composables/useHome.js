import {ref} from "vue";

export const useHome = () => {

    const fetching = ref(false)

    const rows = ref([])

    async function getData(url = '/', page = 1) {
        try {
            fetching.value = true
            const {data} = await axios.get(url)
            rows.value = data.data
        } catch (e) {
            console.log(e)
        } finally {
            fetching.value = false
        }
    }

    return {
        fetching,
        rows,
        getData
    }
}
