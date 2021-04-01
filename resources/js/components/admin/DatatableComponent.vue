<template>
    <data-table
        :columns="columns"
        url="http://dev-maquetacion.com/admin/faqs/json">
    </data-table>
</template>
   
<script>

export default {

    data() {

        return {
            columns: [
                {
                    label: 'id',
                    name: 'id',
                    orderable: true,
                },
                {
                    label: 'title',
                    name: 'title',
                    orderable: true,
                },
                {
                    label: 'description',
                    name: 'description',
                    orderable: true,
                },
            ]
        }
    },
}

</script>