import {ref} from "vue";

export const useDatatable = () => {

    const fetching = ref(false)

    const rows = ref([])

    const pagination = ref({
        current_page: 0,
        last_page: 1,
        total: 0,
        per_page: 10,
        from: 1,
        to: 1,
        next_link: null,
        prev_link: null,
    })

    async function getData(url = '/', page = 1) {
        try {
            fetching.value = true
            const { data } = await axios.get(url, {
                params: {
                    page,
                    limit: 10
                }
            })
            rows.value = data.data
            pagination.value = data.meta
        } catch (e) {
            console.log(e)
        } finally {
            fetching.value = false
        }
    }

    return {
        fetching,
        rows,
        pagination,
        getData
    }
}
