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

    async function getData() {
        try {
            const { data } = await axios.get('/admin/products/list', {
                params: {
                    limit: 10
                }
            })
            rows.value = data.data
            pagination.value = data.meta
        } catch (e) {
            console.log(e)
        }
    }

    return {
        fetching,
        rows,
        pagination,
        getData
    }
}
